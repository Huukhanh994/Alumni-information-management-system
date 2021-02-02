<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Classes;
use App\Models\Major;
use App\Models\MajorBranch;
use App\Models\Academy;
use App\Models\Ward;
use App\Models\City;
use App\Models\District;
use App\Models\ClassUser;
use DB;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $config = [
            'model' => new User(),
            'request' => $request,
        ];
        $this->config($config);
        $students = $this->model->web_index($this->request);

        // Phân trang bị lỗi !
        // $students = User::latest()->get();
        // GET CLASS_CODE
        $class_code = DB::table('users')
            ->join('class_users', 'class_users.user_id', '=', 'users.user_id')
            ->join('classes', 'classes.class_id', '=', 'class_users.class_id')
        ->get();
        //dd($class_code);
        // echo $class_code . '<br>';

        // GET CLASS_NAME
        $class_name = DB::table('users')
            ->join('class_users', 'class_users.user_id', '=', 'users.user_id')
            ->join('classes', 'classes.class_id', '=', 'class_users.class_id')

            ->select('classes.class_name')
        ->value('class_name');
        // echo $class_name . '<br>';

        $academy_code = DB::table('majors')
            ->join('academies', 'academies.academy_id', '=', 'majors.academy_id')

            ->select('academies.academy_code')
        ->value('academy_code');

        $academy_name = DB::table('majors')
        ->join('academies', 'academies.academy_id', '=', 'majors.academy_id')

        ->select('academies.academy_name')
        ->value('academy_name');

        // dd($student);
        return view('pages.admins.students.index', ['students' => $students])
        ->with('class_code', $class_code)
        ->with('class_name', $class_name)
        ->with('academy_code', $academy_code)
        ->with('academy_name', $academy_name);
    }

    public function importExportView()
    {
        return view('import');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function export()
    {
        return Excel::download(new UsersExport(), 'users.xlsx');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function import(Request $request)
    {
        // Excel::import(new UsersImport(), $request->file('file'));
        $users = Excel::toArray(new UsersImport(), $request->file('file'));
        // dd($users);
        foreach ($users[0] as $user) {
            User::insert([
                'code' => $user['MSSV'],
                'name' => $user['Họ và Tên'],
                'password' => Hash::make($user['Mật khẩu']),
                'course' => $user['Khóa'],
                'nation' => $user['Dân tộc'],
                'tel' => $user['SĐT'],
                'email' => $user['Email'],
                'address' => $user['Địa chỉ'],
                'birth' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($user['Ngày sinh']),
                'gender' => $user['Giới tính'],
                'family_tel' => $user['SĐT GĐ'],
                'family_address' => $user['Địa chỉ GĐ'],
                'status_id' => $user['Mã trạng thái'],
                'ward_id' => $user['Mã phường xã'],
            ]);

            $temp1 = User::where('code', $user['MSSV'])->first();
            $temp2 = Classes::where('class_code', $user['Mã lớp'])->first();
            // dd($temp1);
            ClassUser::insert([
            'user_id' => $temp1->user_id,
            'class_id' => $temp2->class_id,
            'class_user_accountability' => 'sinh viên',
        ]);
        }

        return back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admins.students.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
            'name' => 'required',
            'password' => 'required',
            'course' => 'required',
            'nation' => 'required',
            'tel' => 'required',
            'email' => 'required',
            'address' => 'required',
            'birth' => 'required',
            'gender' => 'required',
            'family_tel' => 'required',
            'family_address' => 'required',
       ]);
        $config = [
            'model' => new User(),
            'request' => $request,
        ];
        $this->config($config);
        $student = $this->model->web_insert($this->request);

        $usercode = $this->request->code;
        $classcode = $this->request->class_code;
        $temp1 = User::where('code', $usercode)->first();
        $temp2 = Classes::where('class_code', $classcode)->first();
        ClassUser::insert([
            'user_id' => $temp1->user_id,
            'class_id' => $temp2->class_id,
            'class_user_accountability' => 'sinh viên',
        ]);

        // $config = [
        //     'model' => new ClassUser(),
        //     'request' => $request,
        // ];
        // $this->config($config);
        // $student = $this->model->web_insert($this->request);
        // dd($student);
        return redirect('students')->with('success', 'Added Data Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        $user = User::find($user_id);
        $classuser = ClassUser::where('user_id', $user->user_id)->first();
        $class = Classes::where('class_id', $classuser->class_id)->first();
        $majorbranch = MajorBranch::where('major_branch_id', $class->major_branch_id)->first();
        $major = Major::where('major_id', $majorbranch->major_id)->first();
        $academy = Academy::where('academy_id', $major->academy_id)->first();
        // $birthday = $user->birth->isoFormat('dd/mm/YYYY');
        // $ward = Ward::where('ward_id', $user->ward)->first();
        // $district = District::where('district_id', $ward->district_id)->first();
        // $city = City::where('city_id', $ward->city_id)->first();
        return view('pages.admins.students.show', ['user' => $user, 'class' => $class, 'majorbranch' => $majorbranch, 'major' => $major, 'academy' => $academy]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $user_id)
    {
        $user = User::findOrFail($user_id);
        $classuser = ClassUser::where('user_id', $user->user_id)->first();
        $class = Classes::where('class_id', $classuser->class_id)->first();
        $majorbranch = MajorBranch::where('major_branch_id', $class->major_branch_id)->first();
        $major = Major::where('major_id', $majorbranch->major_id)->first();
        $academy = Academy::where('academy_id', $major->academy_id)->first();

        return view('pages.admins.students.edit', compact('user', 'user_id'), ['user' => $user, 'class' => $class, 'majorbranch' => $majorbranch, 'major' => $major, 'academy' => $academy]);
        //,['students' => $students]
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user_id)
    {
        $this->validate($request, [
            'tel' => 'required',
            'email' => 'required',
            'address' => 'required',
            'family_tel' => 'required',
            'family_address' => 'required',
        ]);
        $user = User::find($user_id);
        //TODO:  Nhan du lieu tu form cu
        $user->tel = $request->get('tel');
        $user->email = $request->get('email');
        $user->address = $request->get('address');
        $user->family_tel = $request->get('family_tel');
        $user->family_address = $request->get('family_address');
        $user->save();

        return redirect('students')->with('success', 'Updated Data Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id)
    {
        $student = User::findOrFail($user_id);
        $student->delete();

        return redirect('students')->with('success', 'Deleted Successfully!');
    }

    // TODO LIVE SEARCH STUDENT AJAX
    public function live_search_student(Request $request)
    {
        if (request()->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = User::with('classes')
                    ->where('code', 'like', '%'.$query.'%')
                    ->orWhere('course', 'like', '%'.$query.'%')
                    ->orWhere('name', 'like', '%'.$query.'%')
                    ->orWhere('nation', 'like', '%'.$query.'%')
                    ->orWhere('tel', 'like', '%'.$query.'%')
                    ->orWhere('email', 'like', '%'.$query.'%')
                    ->orWhere('gender', 'like', '%'.$query.'%')
                    ->orWhere('birth', 'like', '%'.$query.'%')
                    ->orWhere('address', 'like', '%'.$query.'%')
                    ->orWhere('family_tel', 'like', '%'.$query.'%')
                    ->orWhere('family_address', 'like', '%'.$query.'%')
                    ->orWhere('status_id', 'like', '%'.$query.'%')
                    ->orderBy('user_id', 'desc')
                    ->get();
            } else {
                $data = User::with('classes')->orderBy('user_id', 'desc')->get();
            }
            $total_row = $data->count();

            if ($total_row > 0) {
                foreach ($data as $row) {
                    $classes_output = '';
                    foreach ($row->classes as $class) {
                        $classes_output .= '
                            <td>'.$class->class_code.'</td>
                            <td>'.$class->class_name.'</td>
                        ';
                    }
                    $output .= '
                        <tr>
                            <td>'.$row->code.'</td>
                            <td>'.$row->name.'</td>
                            <td>'.$row->tel.'</td>
                            <td>'.$row->email.'</td>
                            '.$classes_output.'
                            <td>      
                                <form action="'.route('students.destroy', $row->user_id).'" method="post" class="delete_form">
                                            
                                    <a href="'.route('students.show', $row->user_id).'" data-toggle="tooltip"  data-original-title="Show"><i class="icon-user"></i></a>
                                    <a href="'.route('students.edit', $row->user_id).'" data-toggle="tooltip"  data-original-title="Edit"><i class="fa fa-pencil text-inverse m-r-10"></i></a>
                                    <button type="submit" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button>
                                </form>
                            </td>
                        </tr>
                    ';
                }
            } else {
                $output .= '
                    <tr>
                        <td align"center" colspan="5">No Data Found</td>
                    </tr>
                ';
            }
            $data = array(
                'table_data' => $output,
                'total_data' => $total_row,
            );
            echo json_encode($data);
        }
    }
}
