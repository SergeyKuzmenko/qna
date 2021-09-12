<?php

namespace App\Http\Controllers;

use App\Models\User;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $user = auth()->user();
        $question = auth()->user()->questions()->without('answers')->limit(3)->get();
        $answers = auth()->user()->answers()->limit(3)->get();

        //dd($user->toArray());
        return view('user', ['user' => $user, 'questions' => $question, 'answers' => $answers]);
    }
}
