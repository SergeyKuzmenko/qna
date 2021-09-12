<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Question;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function questionStore(Request $request)
    {
        $question = Question::findOrFail($request->question_id);
        $comment = Comment::create([
            'user_id' => auth()->user()->id,
            'text' => $request->text,
            'commentable_type' => Question::class,
            'commentable_id' => $question->id
        ]);
        //$question->comments()->create($comment);
        return back()->with('status', 'Коментарий добавлен');
    }
}
