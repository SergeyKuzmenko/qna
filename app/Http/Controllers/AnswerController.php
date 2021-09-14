<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class AnswerController extends Controller
{
    public function store(Question $question, Request $request)
    {
        $answer = $question->answers()->create([
            'body' => clean($request->input('body')),
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
}
