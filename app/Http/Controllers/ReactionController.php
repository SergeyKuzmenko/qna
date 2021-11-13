<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Comment;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReactionController extends Controller
{
    /**
     * @var string
     */
    private $type;
    /**
     * @var int
     */
    private $id;
    /**
     * @var Model
     */
    private $target;

    /**
     * ReactionController constructor.
     * @param Request $request
     */
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
    }

    /**
     * @return JsonResponse
     */
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

    /**
     * @return JsonResponse
     */
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

    /**
     * @return JsonResponse
     */
    public function likes()
    {
        if ($this->target) {
            $users = Profile::whereIn('id', $this->target->likes->pluck('user_id'))
                ->select(['id', 'first_name', 'last_name', 'username', 'avatar', 'short_about'])
                ->get();
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
