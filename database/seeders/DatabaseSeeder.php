<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Profile;
use App\Models\Question;
use App\Models\Tag;
use App\Models\User;
use Faker\Generator;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Total number of users.
     *
     * @var int
     */
    protected $totalUsers = 200;

    /**
     * Percentage of users with questions.
     *
     * @var float Value should be between 0 - 1.0
     */
    protected $userWithQuestionRatio = 0.8;

    /**
     * Maximum questions that can be created by a user.
     *
     * @var int
     */
    protected $maxQuestionsByUser = 15;

    /**
     * Total number of tags.
     *
     * @var int
     */
    protected $totalTags = 100;

    /**
     * Maximum tags that can be attached to an question.
     *
     * @var int
     */
    protected $maxQuestionTags = 5;

    /**
     * Maximum number of answers that can be added to an question.
     *
     * @var int
     */
    protected $maxAnswersOnQuestion = 10;

    /**
     * How many tags the user is subscribed.
     *
     * @var int
     */
    protected $maxTagsOnUser = 10;

    /**
     * Populate the database with dummy data for testing.
     * Complete dummy data generation including relationships.
     * Set the property values as required before running database seeder.
     * @param Generator $faker
     */

    public function run(Generator $faker)
    {
        $users = User::factory()->count($this->totalUsers)->has(Profile::factory())->create();
        $tags = Tag::factory()->count($this->totalTags)->create();

        $users->each(function ($user) use ($faker, $tags) {
            $user->tags()->attach(
                $tags->random($faker->numberBetween(1, $this->maxTagsOnUser))
            );
        });

        $users->random((int)$this->totalUsers * $this->userWithQuestionRatio)
            ->each(function ($user) use ($faker, $tags) {
                $user->questions()
                    ->saveMany(
                        Question::factory()
                            ->count($faker->numberBetween(1, $this->maxQuestionsByUser))
                            ->make()
                    )
                    ->each(function ($question) use ($faker, $tags) {
                        $question->tags()->attach(
                            $tags->random($faker->numberBetween(1, min($this->maxQuestionTags, $this->totalTags)))
                        );
                    })
                    ->each(function ($question) use ($faker) {
                        $question->answers()
                            ->saveMany(
                                Answer::factory()
                                    ->count($faker->numberBetween(0, $this->maxAnswersOnQuestion))
                                    ->make()
                            );
                    });
            });

    }
}
