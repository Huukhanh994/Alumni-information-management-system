<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\Question;
use App\Models\Answer;
use App\Models\User;
use App\Models\Major;
use App\Models\MajorBranch;
use App\Models\Classes;
use DB;
use App\Charts\Charts;
use App\Models\RegisterGraduate;
// Excel
use Excel;
use App\Exports\QuestionsExport;

class StatisticController extends Controller
{
    //khoi tao
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $config = [
            'model' => new Survey(),
            'request' => $request,
        ];
        $this->config($config);
        $data = $this->model->web_index($this->request);

        return view('pages.admins.statistic.index', ['data' => $data]);
    }

    // ajax lấy question thông qua  đổ ra survey
    public static function get_survey($survey_id)
    {
        $question = Question::where('survey_id', $survey_id)->get();
        foreach ($question as $item) {
            if ($item->question_type == 'Radio' || ($item->question_type == 'Checkbox')) {
                echo "$item->question_type"."<option value='".$item->question_id."'>".$item->question_title.'</option>';
            }
        }
    }

    /**
     * Thống kê câu trả lời, dựa trên câu hỏi của khảo sát (form).
     *
     * @param Request
     *
     * @return array $data
     */
    public function answer_statistic(Request $request)
    {
        // Lấy id khảo sát
        $survey_id = $request->get('survey');
        // Lấy id câu hỏi của khảo sát trên
        $question_id = $request->get('question');

        // $question_name = Question::where('question_id', $question_id)->first();
        // $question_name = $question_name['question_title'];

        // Lấy tất cả câu trả lời có câu hỏi = $question_id
        $answer = Answer::where('survey_id', $survey_id)->get();
        // Lấy trường [answer_content], nội dung câu hỏi, dạng json
        $answer = $answer->pluck('answer_content');
        // lặp qua từng câu trả lời, để decode
        foreach ($answer as $item) {
            $temp = json_decode($item, true); // $temp lưu tạm giá trị decode hiện tại
            $val_temp = $temp[$question_id]; // lấy câu trả có id câu hỏi = $question_id, (array)
            // kiểm tra có phải là mảng ko
            // dd($val_temp);
            if (is_array($val_temp)) {
                // nếu < 2, thì chỉ có 1 giá trị, câu hỏi dạng radio
                // ngược lại, có nhiều hơn 1 giá trị, câu hỏi dạng checkbox
                if (count($val_temp) < 2) {
                    // gán câu trả lời vào mảng $answer
                    $answer_content[] = $val_temp[0];
                } else {
                    // Lặp qua, lấy giá trị câu trả lời gán vào mảng $answer
                    foreach ($val_temp as $key => $value) {
                        $answercontent[] = $value;
                    }
                }
            }
        }

        // chuyển về kiểu collect để sử dụng các phương thức count(đếm) và countBy(đếm theo nhóm)
        $answer_content = collect($answer_content);
        // Đếm tất cả
        $count_all = $answer_content->count();
        // Đếm gôm theo nhóm
        $count_by = $answer_content->countBy()->all();
        // Gán các dữ liệu vào $data
        foreach ($count_by  as $key => $value) {
            $ratio = round($value / $count_all, 2) * 100;   // Tính tỷ lệ (%), hàm round(..., 2) làm tròn 2 số thập phân
            $data[] = [
                'label' => $key,    // Câu trả lời (nhãn)
                'total' => $value,  // Tống số user chọn câu trả lời trên
                'ratio' => $ratio,  // Tỷ lệ (%) cho câu trả lời trên
            ];
            // lưu nhãn, dự trù
            $lable[] = $key;
        }
        // Thêm dữ liệu tổng vào cuối, $count_all(tổng số câu trả lời)
        $data[] = ['label' => 'Tổng', 'total' => $count_all, 'ratio' => 100];

        return $data;
    }

    // Export excel thống kê theo from
    public function export(Request $request)
    {
        $data = $request->get('data');
        $data = json_decode($data, true);

        return Excel::download(new QuestionsExport($data), 'Statictis.xlsx');
    }

    // Hàm hiển thị dữ liệu thống kê theo khảo sát (form)
    public function show(Request $request)
    {
        $data = $this->answer_statistic($request);

        $data_json = json_encode($data);

        // $count_array = count($data);
        // foreach ($data as $key => $value) {
        //     if ($key < $count_array - 1) {
        //         foreach ($value as $key1 => $value1) {
        //             if ($key1 == 'label') {
        //                 $lables[] = $value1;
        //             }
        //             if ($key1 == 'total') {
        //                 $values[] = $value1;
        //             }
        //         }
        //     }
        // }

        // $chart = Charts::create('pie', 'highcharts')
        // ->labels($lables)
        // ->values($values)
        // ->dimensions(600, 500)
        // ->responsive(false);

        return view('pages.admins.statistic.show', ['data' => $data, 'data_json' => $data_json]);
    }

    public function student()
    {
        $register_graduate_pass = RegisterGraduate::where('register_graduate_note', 'Tốt Nghiệp')->count('register_graduate_code');
        $total_student = User::join('class_users', 'users.user_id', 'class_users.user_id')
        ->where('class_user_accountability', 'Sinh viên')
        ->count('class_users.user_id');
        // dd($total_student);

        $course = Classes::selectRaw('YEAR(class_begin) as year')->distinct()->get();
        $semester = 0;
        $per = ($register_graduate_pass / $total_student) * 100;

        $graduate_user = User::select('course')->distinct('course')->get();

        // $pass = DB::table('users')->join('register_graduate', 'users.user_id', 'register_graduate.user_id')
        // ->selectRaw('users.*, count(users.user_id) as countUsers')
        // ->groupBy('users.course')
        // ->orderByDesc('countUsers')
        // ->get();

        //dd($pass);
        //danh sách khóa
        // $total = DB::table('users')
        // ->selectRaw('users.*, count(users.user_id) as countUsers')
        // ->groupBy('users.course')
        // ->orderByDesc('countUsers')
        // ->get();

        // dd($graduate_user);
        // $labels = $graduate_user->pluck('course');
        // $values=$register_graduate_pass;
        // $values2=

        // $values = $total->pluck('countUsers');

        // $values2 = $pass->pluck('countUsers');

        // Major
        $major = Major::all();

        // return view('pages.admins.statistic.student', compact('labels', 'values', 'values2', 'register_graduate_pass', 'total_student', 'per', 'course', 'semester', 'major'));
        return view('pages.admins.statistic.student', compact('register_graduate_pass', 'total_student', 'per', 'course', 'semester', 'major'));
    }

    public function course(Request $request)
    {
        $course = $request->course;
        $major = $request->major;
        $major_branch = $request->major_branch;
        $class = $request->class;

        $major_name = Major::select('major_name')->where('major_id', $major);
        $major_branch_name = Major::select('major_branch_name')->where('major_branch_id', $major_branch);
        $class_code = Classes::select('class_name')->where('class_id', $class);

        //course==all -> class=all
        //bắt đầu lấy dữ liệu
        if ($course == 'all') {
            if ($major == 'all') {//tất cả khóa, tất cả ngành (thống kê khoa từ trước tới nay)
                $numerator = RegisterGraduate::where('register_graduate_note', 'Tốt Nghiệp')->count('register_graduate_code');
                $denominator = User::join('class_users', 'users.user_id', 'class_users.user_id')
                ->where('class_user_accountability', 'Sinh viên')
                ->count('class_users.user_id');
            } else {//chọn ngành cụ thể
                if ($major_branch == 'all') {//chọn 1 ngành và tất cả chuyên ngành của ngành đó (VD: THUD và CNTT) (giống ở trên)
                    $numerator = RegisterGraduate::where(['register_graduate_note', 'Tốt Nghiệp'], ['register_graduate_major_name', $major_name])->count('register_graduate_code');
                    $denominator = User::join('class_users', 'users.user_id', 'class_users.user_id')
                    ->join('classes', 'class_users.class_id', 'classes.class_id')
                    ->where(['class_user_accountability', 'Sinh viên'], ['classes.major_id', $major])
                    ->count('class_users.user_id');
                } else {//chọn 1 chuyên ngành
                    if ($class == 'all') {//tất cả lớp thuộc chuyên ngành đó từ trước đến nay
                        $numerator = RegisterGraduate::where(['register_graduate_note', 'Tốt Nghiệp'], ['register_graduate_major_branch_name', $major_branch_name])->count('register_graduate_code');
                        $denominator = User::join('class_users', 'users.user_id', 'class_users.user_id')
                        ->join('classes', 'class_users.class_id', 'classes.class_id')
                        ->where(['class_user_accountability', 'Sinh viên'], ['classes.major_branch_id', $major_branch])
                        ->count('class_users.user_id');
                    }
                    // else {//k có trường hợp này vì course == all
                    // }
                }
            }
        } else {//chọn khóa cụ thể VD 42
            if ($major == 'all') {//tất cả ngành thuộc khóa đó
                $numerator = RegisterGraduate::where(['register_graduate_note', 'Tốt Nghiệp'], ['register_graduate_course', $course])->count('register_graduate_code');
                $denominator = User::join('class_users', 'users.user_id', 'class_users.user_id')
                ->where(['class_user_accountability', 'Sinh viên'], ['users.course', $course])
                ->count('class_users.user_id');
            } else {//chọn ngành cụ thể
                if ($major_branch == 'all') {//tất cả chuyên ngành của ngành đó
                    if ($class == 'all') {//tất cả lớp thuộc ngành, khóa đó
                        $numerator = RegisterGraduate::where(['register_graduate_note', 'Tốt Nghiệp'], ['register_graduate_course', $course], ['register_graduate_major_name', $major_name])->count('register_graduate_code');
                        $denominator = User::join('class_users', 'users.user_id', 'class_users.user_id')
                        ->join('classes', 'class_users.class_id', 'classes.class_id')
                        ->join('majors', 'classes.major_id', 'majors.major_id')
                        ->where(['class_user_accountability', 'Sinh viên'], ['classes.major_id', $major], ['users.course', $course])
                        ->count('class_users.user_id');
                    } else {//1 lớp cụ thể thuộc ngành và khóa đã chọn
                        $numerator = RegisterGraduate::where(['register_graduate_note', 'Tốt Nghiệp'], ['register_graduate_class_code', $class_code])->count('register_graduate_code');
                        $denominator = User::join('class_users', 'users.user_id', 'class_users.user_id')
                        ->join('classes', 'class_users.class_id', 'classes.class_id')
                        ->where(['class_user_accountability', 'Sinh viên'], ['classes.class_id', $class])
                        ->count('class_users.user_id');
                    }
                } else {//chọn 1 chuyên ngành
                    if ($class == 'all') {//tất cả lớp thuộc ngành, khóa đó
                        $numerator = RegisterGraduate::where(['register_graduate_note', 'Tốt Nghiệp'], ['register_graduate_major_branch_name', $major_branch_name])->count('register_graduate_code');
                        $denominator = User::join('class_users', 'users.user_id', 'class_users.user_id')
                        ->join('classes', 'class_users.class_id', 'classes.class_id')
                        ->join('major_branchs', 'classes.major_branch_id', 'major_branchs.major_branch_id')
                        ->where(['class_user_accountability', 'Sinh viên'], ['major_branchs.major_branch_id', $major_branch_id], ['users.course', $course])
                        ->count('class_users.user_id');
                    } else {//1 lớp cụ thể thuộc chuyên ngành và khóa đã chọn
                        $numerator = RegisterGraduate::where(['register_graduate_note', 'Tốt Nghiệp'], ['register_graduate_class_code', $class_code])->count('register_graduate_code');
                        $denominator = User::join('class_users', 'users.user_id', 'class_users.user_id')
                        ->join('classes', 'class_users.class_id', 'classes.class_id')
                        ->join('major_branchs', 'classes.major_branch_id', 'major_branchs.major_branch_id')
                        ->where(['class_user_accountability', 'Sinh viên'], ['classes.class_id', $class])
                        ->count('class_users.user_id');
                    }
                }
            }
        }
        //kết thúc lấy dữ liệu
        $per = round(($numerator / $denominator), 4) * 100;

        if ($request->course == 'all') {
            $register_graduate_pass = RegisterGraduate::join('users', 'register_graduate.user_id', 'users.user_id')
        ->count();
            $total_student = User::count('user_id');
            $per = round($register_graduate_pass / $total_student, 2) * 100;
            $course = User::select('course')->distinct()->get();
            $semester = 0;
        } else {
            $register_graduate_pass = RegisterGraduate::join('users', 'register_graduate.user_id', 'users.user_id')
        // ->count('register_graduate.user_id')
        // ->having('users.course', '=', $request->year);
        ->where('users.course', '=', $request->course)
        ->count();
            $total_student = User::where('course', $request->course)
        ->count('user_id');
            $per = round($register_graduate_pass / $total_student, 2) * 100;
            $course = User::select('course')->distinct()->get();
            $semester = 0;
        }
        $graduate_user = User::select('course')->distinct('course')->get();

        $pass = DB::table('users')->join('register_graduate', 'users.user_id', 'register_graduate.user_id')
        ->selectRaw('users.*, count(users.user_id) as countUsers')
        ->groupBy('users.course')
        ->orderByDesc('countUsers')
        ->get();
        // dd($pass);
        //danh sách khóa
        $total = DB::table('users')
        ->selectRaw('users.*, count(users.user_id) as countUsers')
        ->groupBy('users.course')
        ->orderByDesc('countUsers')
        ->get();
        // dd($graduate_user);
        $labels = $graduate_user->pluck('course');

        $values = $total->pluck('countUsers');

        $values2 = $pass->pluck('countUsers');

        return view('pages.admins.statistic.student', compact('labels', 'values', 'values2', 'register_graduate_pass', 'total_student', 'per', 'course', 'semester'));
    }

    // Ajax lấy chuyên ngành theo ngành
    public function get_major_branch($major_id)
    {
        $major_branch = MajorBranch::where('major_id', $major_id)->get();
        echo "<option value='all'>Tất cả</option>";
        foreach ($major_branch as $item) {
            echo "<option value='".$item->major_branch_id."'>".$item->major_branch_name.'</option>';
        }
    }

    // Ajax lấy lơp theo chuyên ngành
    public function get_class($major_id, $major_branch_id, $course)
    {
        // if ($course == 'all') {
        //     echo "<option value='all'>all</option>";
        // } else {
        $class = Classes::where('major_id', $major_id)
        ->orWhere('major_branch_id', $major_branch_id)
        ->whereYear('class_begin', $course)
        ->get();

        echo "<option value='all'>all</option>";
        foreach ($class as $item) {
            echo "<option value='".$item->class_id."'>".$item->class_name.'</option>';
        }
        // }
    }
}
