<?php

namespace Database\Factories;

use App\Models\Flashcard;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class FlashcardFactory
 * @package Database\Factories
 */
class FlashcardFactory extends Factory
{
    protected $model = Flashcard::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'question' => $this->faker->sentence,
            'answer'   => $this->faker->sentence,
        ];
    }
}
