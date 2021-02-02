<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Question;
use App\Models\Survey;
use App\Models\Answer;

class AnswerController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function store(Request $request, Survey $survey)
    {
        // remove the token
        $arr = $request->except('_token');
        foreach ($arr as $key => $value) {
            $Answer = new Answer();
            $Question = Question::findOrFail($key);
            //check câu hỏi bắt buộc
            if (!is_array($value)) {
                $Value = $value[$key];
            } else {
                $Value = json_encode($arr, true);
            }
        }
        $Answer->insert([
            'survey_id' => $survey->survey_id,
            'user_id' => Auth::user()->user_id,
            'answer_content' => $Value,
            ]);

        return back()->with('success', 'Successful Survey!');
    }
}
