<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Question::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence($this->faker->numberBetween(1, 5)),
            'body' => $this->faker->paragraph($this->faker->numberBetween(10, 20)),
            'user_id' => User::all()->random()->id,
            'views' => $this->faker->numberBetween(1, 100),
            'complexity' => $this->faker->numberBetween(1, 3),
        ];
    }
}
