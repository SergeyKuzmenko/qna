<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function all(Request $request, User $user)
    {
        switch ($request->get('by')) {
            case 'questions':
                $users = $user->getUsersByQuestions();
                break;
            case 'answers':
                $users = $user->getUsersByAnswers();
                break;
            case 'rating':
                $users = $user->getUsersByRating();
                break;
            case 'tag':
                $users = $user->getUsersByTag($request->get('tag'));
                break;
            default:
                $users = $user->getUsersByDefault();
                break;
        }
        return view('users', ['users' => $users->appends(request()->query()), 'title' => 'Пользователи']);
    }

    public function info($username)
    {
        $profile = Profile::where('username', $username)->first();
        if ($profile){
            $user = $profile->user()->withCount(['questions', 'answers'])->first();
            $question = $user->questions()->without('answers')->limit(3)->get();
            $answers = $user->answers()->limit(3)->get();
            return view('user', ['user' => $user, 'questions' => $question, 'answers' => $answers]);
        } else {
            return abort(404);
        }
    }
}
