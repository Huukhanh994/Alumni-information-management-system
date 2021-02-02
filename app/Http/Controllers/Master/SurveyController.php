<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Survey;
use App\Models\User;
use Carbon\Carbon;
// Export
use Excel;
use App\Exports\SurveysExport;
// Array
use Illuminate\Support\Arr;

class SurveyController extends Controller
{
    //khoi tao
    public function __construct()
    {
        parent::__construct();
    }

    public function home(Request $request)
    {
        $surveys = Survey::get();

        return view('home', compact('surveys'));
    }

    public function index(Request $request)
    {
        $config = [
          'model' => new Survey(),
          'request' => $request,
        ];
        $this->config($config);
        $survey = $this->model->web_index($this->request);

        return view('pages.admins.survey.index', ['survey' => $survey]);
    }

    // Show page to create new survey
    public function create_render()
    {
        return view('pages.admins.survey.create');
    }

    public function create_submit(Request $request)
    {
        $this->validate($request, [
      'survey_name' => 'required',
      'survey_description' => 'required',
      'survey_version' => 'required',
      //set ngày bắt đầu trước ngày kết thúc
      'survey_start' => 'required|date|before:survey_end',
      'survey_end' => 'required|date|after:survey_start',
  ]);
        $surveys = new Survey();
        $surveys->user_id = Auth::user()->user_id;
        $surveys->survey_name = $request->get('survey_name');
        $surveys->survey_description = $request->get('survey_description');
        $surveys->survey_start = $request->get('survey_start');
        $surveys->survey_end = $request->get('survey_end');
        $surveys->survey_version = $request->get('survey_version');

        $survey_id = $surveys->insertGetId([
          'user_id' => $surveys->user_id,
          'survey_name' => $surveys->survey_name,
          'survey_description' => $surveys->survey_description,
          'survey_start' => $surveys->survey_start,
          'survey_end' => $surveys->survey_end,
          'survey_version' => $surveys->survey_version,
        ]);

        return redirect("/survey/{$survey_id}");
    }

    public function detail_survey(Survey $survey)
    {
        return view('pages.admins.survey.detail', compact('survey'));
    }

    public function edit(Survey $survey)
    {
        $survey_id = Survey::findOrFail($survey->survey_id);

        return view('pages.admins.survey.edit', compact('survey', 'survey_id'));
    }

    public function view_survey(Survey $survey)
    {
        //set ngày khảo sát
    $day = Carbon::now()->day; //ngày
    $month = Carbon::now()->month; //tháng
    $year = Carbon::now()->year; //năm
    $start_day = Carbon::parse($survey->survey_start)->day;
        $start_month = Carbon::parse($survey->survey_start)->month;
        $start_year = Carbon::parse($survey->survey_start)->year;
        $end_day = Carbon::parse($survey->survey_end)->day;
        $end_month = Carbon::parse($survey->survey_end)->month;
        $end_year = Carbon::parse($survey->survey_end)->year;
        if ($start_year <= $year && $year <= $end_year) {
            if ($start_month <= $month && $month <= $end_month) {
                if ($start_day <= $day && $day <= $end_day) {
                    return view('pages.admins.survey.view', compact('survey'));
                }
                //sau khi hoàn thành set lại trang back
                else {
                    return back()->with('error', 'Chưa đến thời gian khảo sát');
                }
            }
            //sau khi hoàn thành set lại trang back
            else {
                return back()->with('error', 'Chưa đến thời gian khảo sát');
            }
        }
        //sau khi hoàn thành set lại trang back
        else {
            return back()->with('error', 'Chưa đến thời gian khảo sát');
        }
    }

    // view submitted answers from current logged in user
    public function view_survey_answers(Survey $survey)
    {
        $survey->load('answers', 'questions');

        $survey_arr = $survey->load('answers')->toArray();

        // Lay user
        foreach($survey->answers as $item) {
            $name = $item->users->name;
            $code = $item->users->code;
            $users[] =[
                'name' => $name,
                'code' => $code,
            ];
        }

        $survey_json = json_encode(Arr::add($survey_arr, 'users', $users));
        
        // dd($users);
        return view('pages.admins.answer.view', compact('survey', 'survey_json'));
    }

    public function update(request $request, $survey_id)
    {
        $survey = Survey::find($survey_id);
        //lấy id người tạo
        $survey->user_id = Auth::user()->user_id;
        $survey->survey_name = $request->get('survey_name');
        $survey->survey_description = $request->get('survey_description');
        $survey->survey_start = $request->get('survey_start');
        $survey->survey_end = $request->get('survey_end');
        $survey->survey_version = $request->get('survey_version');

        $survey->save();

        return redirect('survey')->with('success', 'Updated Successfully!');
    }

    public function destroy($survey_id)
    {
        $data = Survey::findOrFail($survey_id);
        $data->delete();

        return redirect('survey')->with('success', 'Deleted Successfully!');
    }

    public function export(Request $request)
    {
        $survey = $request->get('data');
        $survey = json_decode($survey, true);
        // dd($survey);

        return Excel::download(new SurveysExport($survey), 'survey.xlsx');
    }
}
