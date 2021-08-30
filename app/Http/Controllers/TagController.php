<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function all(Request $request, Tag $tag)
    {
        switch ($request->get('by')) {
            case 'followers':
                $tags = $tag->getTagsByFollowers();
                break;
            case 'questions':
                $tags = $tag->getTagsByQuestions();
                break;
            default:
                $tags = $tag->getTagsByDefault();
                break;
        }
        return view('tags', ['tags' => $tags->appends(request()->query())]);
    }

    public function info($slug)
    {
        $tag = Tag::where('slug', $slug)->first();
        if ($tag) {
            return view('tag', ['tag' => $tag->getTagInfo($tag->id)]);
        } else {
            return abort(404);
        }
    }

    public function questions($slug, Request $request, Question $question)
    {
        $tag = Tag::where('slug', $slug)->first();
        if ($tag) {
            $tagName = $tag->title;
            $questions = $question->getQuestionsByTag([$tag->id], $request->get('by'));
            return view('feed', ['questions' => $questions->appends(request()->query()), 'title' => 'Вопросы по тегу «'.$tagName.'»']);
        } else {
            return abort(404);
        }
    }

    public function followers($slug)
    {
        $tag = Tag::where('slug', $slug)->first();
        if ($tag) {
            $tagName = $tag->title;
            return view('users', ['users' => $tag->followers->paginate(20), 'title' => 'Подписчики тега «'.$tagName.'»']);
        } else {
            return abort(404);
        }
    }

    public function subscribe($slug)
    {
        $tag = Tag::where('slug', $slug)->first();
        if ($tag) {
            $tag->subscribe();
            return redirect()->back()->with('status', 'Вы подписаны');
        } else {
            return abort(404);
        }
    }

    public function unsubscribe($slug)
    {
        $tag = Tag::where('slug', $slug)->first();
        if ($tag) {
            $tag->unsubscribe();
            return redirect()->back()->with('status', 'Вы отписаны');
        } else {
            return abort(404);
        }
    }
}
