<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewQuestionRequest;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function all(Request $request, Question $question)
    {
        switch ($request->get('by')) {
            case 'new':
                $questions = $question->getAllQuestionsByNew();
                $title = 'Новые вопросы';
                break;
            case 'interesting':
                $questions = $question->getAllQuestionsByInteresting();
                $title = 'Интересные вопросы';
                break;
            case 'without_answers':
                $questions = $question->getAllQuestionsByWithoutAnswers();
                $title = 'Вопросы без ответа';
                break;
            default:
                $questions = $question->getAllQuestionsByDefault();
                $title = 'Новые вопросы';
                break;
        }

        return view('feed', ['questions' => $questions->appends(request()->query()), 'title' => $title]);
    }

    public function new()
    {
        return view('new');
    }

    public function store(NewQuestionRequest $request, Question $question)
    {
        $question->newQuestion($request);
        return redirect(route('question.show', ['id' => $question->id]));
    }


    public function show(Question $id)
    {
        $id->increment('views');
        //dd($id->toArray());
        return view('question', ['question' => $id]);
    }

    public function subscribe(Request $request)
    {
        $question_id = $request->input('question_id');
        $question = Question::find($question_id);
        if ($question) {
            $question->subscribe();
            return response()->json([
                'msg' => 'Вы подписаны',
                'count_subscribers' => $question->count_subscribers
            ]);
        } else {
            return response()->json([
                'error' => 'Bad request. Undefined target question',
            ], 400);
        }
    }

    public function unsubscribe(Request $request)
    {
        $question_id = $request->input('question_id');
        $question = Question::find($question_id);
        if ($question) {
            $question->unsubscribe();
            return response()->json([
                'msg' => 'Подписаться',
                'count_subscribers' => $question->count_subscribers
            ]);
        } else {
            return response()->json([
                'error' => 'Bad request. Undefined target question',
            ], 400);
        }
    }
}
