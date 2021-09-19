<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Contracts\View\View;

class MyController extends Controller
{
    /**
     * MyController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return View
     */
    public function index()
    {
        $tagsId = auth()->user()->tags()->pluck('tag_id')->toArray();
        $questions = Question::whereHas('tags', function ($query) use ($tagsId) {
            $query->whereIn('tags.id', $tagsId);
        })->withCount('answers')->with(['user.profile', 'tags'])->orderBy('created_at')->paginate(20);
        return view('my.feed', ['questions' => $questions->appends(request()->query())]);
    }

    /**
     * @return View
     */
    public function questions()
    {
        $questions = auth()->user()->questions()->withCount('answers')->orderBy('created_at', 'asc')->paginate(20);
        return view('my.questions', ['questions' => $questions->appends(request()->query())]);
    }

    /**
     * @return View
     */
    public function answers()
    {
        $answers = auth()->user()->answers()->with(['question', 'user'])->paginate(20);
        return view('my.answers', ['answers' => $answers->appends(request()->query())]);
    }

    /**
     * @return View
     */
    public function tags()
    {
        $tags = auth()->user()->tags()->withExists(['followers as is_follow' => function ($query) {
            $query->where('user_id', auth()->user()->id);
        }])->withCount(['questions', 'followers'])->paginate(20);
        return view('my.tags', ['tags' => $tags->appends(request()->query())]);
    }

}
