<?php

namespace Database\Factories;

use App\Models\Practice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class PracticeFactory
 * @package Database\Factories
 */
class PracticeFactory extends Factory
{
    protected $model = Practice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'question_id'           => $this->faker->randomDigitNotNull,
            'answer'                => $this->faker->sentence,
            'is_answered_correctly' => $this->faker->boolean,
        ];
    }
}
