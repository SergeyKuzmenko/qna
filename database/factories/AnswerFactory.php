<?php

namespace Database\Factories;

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnswerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Answer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::all();
        $questions = Question::all();
        return [
            'body' => $this->faker->paragraph($this->faker->numberBetween(1, 5)),
            'is_solution' => $this->faker->numberBetween(0, 1),
            'user_id' => $user->random()->id,
            'question_id' => $questions->random()->id
        ];
    }
}
