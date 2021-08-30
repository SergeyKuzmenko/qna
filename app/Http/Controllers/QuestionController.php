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
        return view('question', ['question' => $id]);
    }
}