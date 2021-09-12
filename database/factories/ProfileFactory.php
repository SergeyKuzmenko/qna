<?php

namespace Database\Factories;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Profile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->unique()->name;
        return [
            'username' => Str::slug($name),
            'rating' => 0,
            'first_name' => explode(' ', $name)[0],
            'last_name' => explode(' ', $name)[1],
            'education' => $this->faker->address,
            'location' => $this->faker->streetAddress(),
            'skills' => $this->faker->words(3, true),
            'short_about' => $this->faker->sentence(3),
            'about' => $this->faker->text(),
            'avatar' => 'https://i.pravatar.cc/300?u=' . Str::random(20)
        ];
    }
}
