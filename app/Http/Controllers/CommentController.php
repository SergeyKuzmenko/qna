<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Comment;
use App\Models\Question;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ModelNotFoundException
     */
    public function store(Request $request): JsonResponse
    {
        $target = $request->input('type');
        $id = $request->input('id');
        $comment_text = $request->input('text');

        $comment = new Comment([
            'user_id' => auth()->id(),
            'text' => $comment_text
        ]);

        if ($target) {
            switch ($target) {
                case 'question':
                    $comment = Question::findOrFail($id)->comments()->save($comment);
                    break;
                case 'answer':
                    $comment = Answer::findOrFail($id)->comments()->save($comment);
                    break;
            }
        } else {
            return response()->json([
                'error' => 'Undefined target'
            ], 400);
        }
        return response()->json([
            'success' => true,
            'comment_id' => $comment->id
        ]);

    }

    /**
     * @todo
     */
    public function edit(): void
    {

    }

    /**
     * @todo
     */
    public function destroy(): void
    {

    }
}
