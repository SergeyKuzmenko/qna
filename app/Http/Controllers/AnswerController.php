<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class AnswerController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $question_id = $request->input('question_id');
        $answer_text = $request->input('answer_text');

        $answer = Question::find($question_id)->answers()->create([
            'body' => clean($answer_text),
            'user_id' => auth()->user()->id,
        ]);

        if ($answer) {
            return response()->json([
                'success' => true,
                'answer_id' => $answer->id,
                'answer_html' => View::make('components.answer', ['answer' => $answer])->render()
            ]);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Bad request. Undefined target question'
            ], 400);
        }
    }

    /**
     * @todo
     */
    public function edit()
    {

    }

    /**
     * @todo
     */
    public function destroy(Request $request)
    {
        $answer_id = $request->input('answer_id');
        $answer = Answer::findOrFail($answer_id);
        if ($answer->user_id === auth()->user()->id) {
            $answer->delete();
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Access denied'
            ],403);
        }


    }
}
