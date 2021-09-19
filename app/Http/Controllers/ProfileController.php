<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class ProfileController extends Controller
{
    /**
     * ProfileController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return View
     */
    public function show()
    {
        $user = auth()->user();
        $question = auth()->user()->questions()->without('answers')->limit(3)->get();
        $answers = auth()->user()->answers()->limit(3)->get();
        return view('user', ['user' => $user, 'questions' => $question, 'answers' => $answers]);
    }
}
