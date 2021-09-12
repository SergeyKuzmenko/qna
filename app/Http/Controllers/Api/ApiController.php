<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;

class ApiController extends Controller
{
    public function subscribeToQuestion(Question $question)
    {
        if ($question) {
            $question->subscribe();
            return response()->json([
                'msg' => 'Вы подписаны',
                'count_subscribers' => $question->count_subscribers
            ]);
        } else {
            return response()->json([
                'error' => 'Нет параметра question_id',
            ], 400);
        }
    }

    public function unsubscribeFromQuestion(Question $question)
    {
        if ($question) {
            $question->unsubscribe();
            return response()->json([
                'msg' => 'Вы не пописаны на вопрос',
                'count_subscribers' => $question->count_subscribers
            ]);
        } else {
            return response()->json([
                'error' => 'Нет параметра question_id',
            ], 400);
        }
    }

    public function likeAnswer(Answer $answer)
    {
        if ($answer) {
            $answer->like();
            return response()->json([
                'msg' => 'Вам нравится',
                'likes_count' => $answer->likeCount
            ]);
        } else {
            return response()->json([
                'error' => 'Нет параметра answer_id',
            ], 400);
        }
    }

    public function unlikeAnswer(Answer $answer)
    {
        if ($answer) {
            $answer->unlike();
            return response()->json([
                'msg' => 'Нравится',
                'likes_count' => $answer->likeCount
            ]);
        } else {
            return response()->json([
                'error' => 'Нет параметра answer_id',
            ], 400);
        }
    }

    public function likesListAnswer(Answer $answer)
    {
        if ($answer) {
            return response()->json([
                'likes' => $answer->likes
            ]);
        } else {
            return response()->json([
                'error' => 'Нет параметра answer_id',
            ], 400);
        }

    }

}
