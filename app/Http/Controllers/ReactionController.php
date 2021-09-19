<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Comment;
use App\Models\Profile;
use Illuminate\Http\Request;

class ReactionController extends Controller
{
    private $type;
    private $id;
    private $target;

    function __construct(Request $request)
    {
        $this->type = $request->input('type');
        $this->id = $request->input('id');

        switch ($this->type) {
            case 'answer':
                $this->target = Answer::find($this->id);
                break;
            case 'comment':
                $this->target = Comment::find($this->id);
                break;
            default:
                $target = null;
                break;
        }
        return $this->target;
    }

    public function like()
    {
        if ($this->target) {
            $this->target->like();
            return response()->json([
                'success' => true,
                'msg' => 'Вам нравится',
                'likes_count' => $this->target->likeCount
            ]);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Bad request. Undefined target'
            ], 400);
        }
    }

    public function unlike()
    {
        if ($this->target) {
            $this->target->unlike();
            return response()->json([
                'success' => true,
                'msg' => 'Нравится',
                'likes_count' => $this->target->likeCount
            ]);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Bad request. Undefined target'
            ], 400);
        }
    }

    public function likes()
    {
        if ($this->target) {
            $users = Profile::whereIn('id', $this->target->likes->pluck('id'))->get();
            return response()->json([
                'success' => true,
                'likes' => $users
            ]);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Bad request. Undefined target'
            ], 400);
        }

    }
}
