<?php

namespace App\View\Components;

use Illuminate\View\Component;

/**
 * Class Question
 * @package App\View\Components
 */
class Question extends Component
{
    /**
     * @var
     */
    public $question;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($question)
    {
        $this->question = $question;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.question');
    }
}
