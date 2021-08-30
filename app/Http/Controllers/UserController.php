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
        //dd($users);
        return view('users', ['users' => $users->appends(request()->query()), 'title' => 'Пользователи']);
    }

    public function info($username)
    {
        $profile = Profile::where('username', $username)->first();
        if ($profile){
            $user = User::where('id', $profile->id)->first();
            $data = $user->getUserProfileData($profile->id);
            //dd($data->toArray());
            return view('user', ['user' => $data]);
        } else {
            abort(404);
        }
    }
}
