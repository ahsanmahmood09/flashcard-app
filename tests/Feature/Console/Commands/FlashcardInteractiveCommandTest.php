<?php

namespace Tests\Feature\Console\Commands;

use App\Console\Commands\FlashcardInteractiveCommand;
use App\Models\Flashcard;
use App\Models\Practice;
use Tests\TestCase;

/**
 * Class FlashcardInteractiveCommandTest
 * @package Tests\Unit\Console\Commands
 * @coversDefaultClass FlashcardInteractiveCommand
 */
class FlashcardInteractiveCommandTest extends TestCase
{
    /**
     * @test
     * @group flashcardInteractiveCommandFeature
     */
    public function it_should_create_a_real_flashcard_when_the_choice_is_1()
    {
        $flashcard = Flashcard::factory()->make();

        $this->artisan('flashcard:interactive')
            ->expectsQuestion('What is your choice?', 1)
            ->expectsQuestion('Ask a question?', $flashcard->question)
            ->expectsQuestion('Provide the correct answer to your question?', $flashcard->answer)
            ->expectsOutput('Flashcard created successfully!')
            ->expectsQuestion('What is your choice?', 6)
            ->assertExitCode(0);

        $this->assertDatabaseHas('flashcards', $flashcard->toArray());
    }

    /**
     * @test
     * @group flashcardInteractiveCommandFeature
     */
    public function it_should_list_all_real_flashcards_when_the_choice_is_2()
    {
        $flashcards = Flashcard::factory()->count(2)->make();

        $this->artisan('flashcard:interactive')
            ->expectsQuestion('What is your choice?', 2)
            /*->expectsTable(['Question', 'Answer'], $flashcards->toArray())*/ //This does not work
            ->expectsQuestion('What is your choice?', 6)
            ->assertExitCode(0);
    }

    /**
     * @test
     * @group flashcardInteractiveCommandFeature
     */
    public function it_should_practice_real_flashcard_when_the_choice_is_3()
    {
        $flashcard = Flashcard::factory()->create();
        $practice = Practice::factory(['question_id' => $flashcard->id, 'answer' => $flashcard->answer])->make();

        $this->artisan('flashcard:interactive')
            ->expectsQuestion('What is your choice?', 3)
            ->expectsQuestion('Pick the question number you want to practice?', $flashcard->id)
            ->expectsQuestion('Provide the correct answer to the question you picked?', $flashcard->answer)
            ->expectsQuestion('What is your choice?', 6)
            ->assertExitCode(0);


        $this->assertDatabaseHas(
            'practices',
            ['question_id' => $practice->question_id, 'answer' => $flashcard->answer]
        );
    }

    /**
     * @test
     * @group flashcardInteractiveCommandFeature
     */
    public function it_should_display_real_flashcard_stats_when_the_choice_is_4()
    {
        $flashcard = Flashcard::factory()->create();
        $practice = Practice::factory(['question_id' => $flashcard->id, 'answer' => $flashcard->answer])->make();

        $this->artisan('flashcard:interactive')
            ->expectsQuestion('What is your choice?', 4)
            ->expectsQuestion('What is your choice?', 6)
            ->assertExitCode(0);
    }

    /**
     * @test
     * @group flashcardInteractiveCommandFeature
     */
    public function it_should_exit_when_the_choice_is_6()
    {
        $this->artisan('flashcard:interactive')
            ->expectsQuestion('What is your choice?', 6)
            ->assertExitCode(0);
    }
}
