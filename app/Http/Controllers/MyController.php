<?php

namespace App\Http\Controllers;

use App\Models\Question;

class MyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $tagsId = auth()->user()->tags()->pluck('tag_id')->toArray();
        $questions = Question::whereHas('tags', function ($query) use ($tagsId) {
            $query->whereIn('tags.id', $tagsId);
        })->withCount('answers')->with(['user.profile', 'tags'])->orderBy('created_at')->paginate(20);
        return view('my.feed', ['questions' => $questions]);
    }

    public function questions()
    {
        $questions = auth()->user()->questions()->withCount('answers')->orderBy('created_at', 'asc')->paginate(20);
        return view('my.questions', ['questions' => $questions]);
    }

    public function answers()
    {
        $answers = auth()->user()->answers()->with('question', function ($query) {
            $query->select(['id', 'title', 'created_at', 'user_id'])->without(['tags', 'answers']);
        })->paginate(20);
        return view('my.answers', ['answers' => $answers]);
    }

    public function tags()
    {
        $tags = auth()->user()->tags()->withExists(['followers as is_follow' => function ($query) {
            $query->where('user_id', auth()->user()->id);
        }])->withCount(['questions', 'followers'])->paginate(20);
        return view('my.tags', ['tags' => $tags]);
    }

}
