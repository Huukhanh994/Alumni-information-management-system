<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Models\Question;

class QuestionController extends Controller
{
    // Ham khoi tao
    public function __construct()
    {
        parent::__construct();
    }

    public function store(Request $request, Survey $survey)
    {
        // dd($request);
        if (($request->question_mandatory)) {
            $question_mandatory = $request->question_mandatory;
        } else {
            $question_mandatory = null;
        }
        $arr = $request->except('_token');
        // dd($arr);
        // if($question_mandatory==null){

        // }else{}
        //duyệt request lưu dạng json
        if (is_array($arr)) {
            foreach ($arr as $key => $value) {
                $Question = new Question();
                if (is_array($value)) {
                    $Option = json_encode($arr, true);
                } else {
                    $Option = '';
                }
            }
        }
        $tam = json_decode($Option, true);
        if (!empty($tam)) {
            foreach ($tam as $key => $value) {
                //xóa bớt các thành phần không cần thiết từ request
                if (!is_array($value)) {
                    unset($tam[$key]);
                }
                $v = $value;
            }
            $op = '{"option":'.json_encode($v, true).'}';
        } else {
            $op = null;
        }

        $Question->insert([
        'survey_id' => $survey->survey_id,
        'question_title' => $request->question_title,
        'question_mandatory' => $question_mandatory,
        'question_type' => $request->question_type,
        'question_option' => $op,
      ]);

        return back()->with('success', 'Successful Survey!');
    }

    public function edit(Question $question)
    {
        $question_id = Question::findOrFail($question->question_id);

        return view('pages.admins.question.edit', compact('question', 'question_id'));
    }

    //chưa fix lỗi json
    public function update(Request $request, $question_id)
    {
        $title = $request->question_title;
        $Option = '';
        $arr = $request->except('_token', 'question_title');

        if (is_array($arr)) {
            $Question = Question::findOrFail($question_id);
            foreach ($arr as $key => $value) {
                if (!is_array($value)) {
                    $title = $value[$value];
                } else {
                    $Option = json_encode($arr, true);
                }

                $questionArray[] = $Question;
            }
        }
        //chưa làm xóa và thay đổi bắt buộc
        $Question->update([
                    'question_title' => $title,
                    'question_option' => $Option,
                ]);

        return back()->with('success', 'Updated Successfully!');
    }

    public function delete(Request $request, $question_id, $item1)
    {
        $Question = Question::where('question_id', $question_id)->get()->toArray();
        $Question2 = Question::findOrFail($question_id);
        $option = data_get($Question, '0.question_option');
        $obj = json_decode($option, true);
        foreach ($obj as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    unset($v[$item1]);
                    break;
                }
            }
            $tam = $v;
            break;
        }
        $op = '{"option":'.json_encode($tam, true).'}';
        $Question2->update([
            'question_option' => $op,
        ]);

        return back()->with('success', 'Updated Successfully!');
    }
}
