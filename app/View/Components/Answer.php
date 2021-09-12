<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Answer extends Component
{
    public $answer;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($answer)
    {
        $this->answer = $answer;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.answer');
    }
}
