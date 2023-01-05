<?php

namespace Tests\Unit\Console\Commands;

use App\Console\Commands\FlashcardInteractiveCommand;
use App\Models\Flashcard;
use App\Models\Practice;
use App\Repositories\FlashcardRepositoryInterface;
use App\Repositories\PracticeRepositoryInterface;
use App\Services\FlashcardInteractiveService;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionException;
use Tests\TestCase;

/**
 * Class FlashcardInteractiveCommandTest
 * @package Tests\Unit\Console\Commands
 * @coversDefaultClass FlashcardInteractiveCommand
 */
class FlashcardInteractiveCommandTest extends TestCase
{
    /** @var FlashcardInteractiveCommand|MockObject $flashcardInteraciveCommand */
    private FlashcardInteractiveCommand|MockObject $flashcardInteractiveCommand;

    /** @var FlashcardInteractiveService|MockObject $flashcardInteractiveService */
    private FlashcardInteractiveService|MockObject $flashcardInteractiveService;

    /** @var FlashcardRepositoryInterface|MockObject $flashcardRepository */
    private FlashcardRepositoryInterface|MockObject $flashcardRepository;

    /** @var PracticeRepositoryInterface|MockObject $practiceRepository */
    private PracticeRepositoryInterface|MockObject $practiceRepository;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->flashcardInteractiveService = $this->createMock(FlashcardInteractiveService::class);
        $this->flashcardRepository = $this->createMock(FlashcardRepositoryInterface::class);
        $this->practiceRepository = $this->createMock(PracticeRepositoryInterface::class);

        parent::setUp();
    }

    /**
     * @param array $methods
     * @return void
     */
    private function onlyMethods(array $methods = []): void
    {
        $this->setUp();

        $this->flashcardInteractiveCommand = $this->getMockBuilder(FlashcardInteractiveCommand::class)
            ->setConstructorArgs(
                [$this->flashcardInteractiveService, $this->flashcardRepository, $this->practiceRepository]
            )
            ->onlyMethods($methods)
            ->getMock();
    }

    /**
     * @test
     * @group flashcardInteractiveCommand
     * @covers FlashcardInteractiveCommand::handle
     */
    public function it_should_create_a_flashcard_when_the_choice_is_1()
    {
        $this->onlyMethods(['showMenu', 'createFlashcard', 'ask', 'newLine']);

        $this->flashcardInteractiveCommand
            ->expects($this->exactly(2))
            ->method('showMenu');
        $this->flashcardInteractiveCommand
            ->expects($this->exactly(2))
            ->method('ask')
            ->withConsecutive(['What is your choice?'], ['What is your choice?'])
            ->willReturnOnConsecutiveCalls(1, 6);
        $this->flashcardInteractiveCommand
            ->expects($this->once())
            ->method('createFlashcard');
        $this->flashcardInteractiveCommand
            ->expects($this->exactly(2))
            ->method('newLine');

        $this->assertEmpty($this->flashcardInteractiveCommand->handle());
    }

    /**
     * @test
     * @group flashcardInteractiveCommand
     * @covers FlashcardInteractiveCommand::handle
     */
    public function it_should_list_all_flashcards_when_the_choice_is_2()
    {
        $this->onlyMethods(['showMenu', 'listAllFlashcards', 'ask', 'newLine']);

        $this->flashcardInteractiveCommand
            ->expects($this->exactly(2))
            ->method('showMenu');
        $this->flashcardInteractiveCommand
            ->expects($this->exactly(2))
            ->method('ask')
            ->withConsecutive(['What is your choice?'], ['What is your choice?'])
            ->willReturnOnConsecutiveCalls(2, 6);
        $this->flashcardInteractiveCommand
            ->expects($this->once())
            ->method('listAllFlashcards');
        $this->flashcardInteractiveCommand
            ->expects($this->exactly(2))
            ->method('newLine');

        $this->assertEmpty($this->flashcardInteractiveCommand->handle());
    }

    /**
     * @test
     * @group flashcardInteractiveCommand
     * @covers FlashcardInteractiveCommand::handle
     */
    public function it_should_practice_flashcards_when_the_choice_is_3()
    {
        $this->onlyMethods(['showMenu', 'practice', 'ask', 'newLine']);

        $this->flashcardInteractiveCommand
            ->expects($this->exactly(2))
            ->method('showMenu');
        $this->flashcardInteractiveCommand
            ->expects($this->exactly(2))
            ->method('ask')
            ->withConsecutive(['What is your choice?'], ['What is your choice?'])
            ->willReturnOnConsecutiveCalls(3, 6);
        $this->flashcardInteractiveCommand
            ->expects($this->once())
            ->method('practice');
        $this->flashcardInteractiveCommand
            ->expects($this->exactly(2))
            ->method('newLine');

        $this->assertEmpty($this->flashcardInteractiveCommand->handle());
    }

    /**
     * @test
     * @group flashcardInteractiveCommand
     * @covers FlashcardInteractiveCommand::handle
     */
    public function it_should_display_flashcards_stats_when_the_choice_is_4()
    {
        $this->onlyMethods(['showMenu', 'stats', 'ask', 'newLine']);

        $this->flashcardInteractiveCommand
            ->expects($this->exactly(2))
            ->method('showMenu');
        $this->flashcardInteractiveCommand
            ->expects($this->exactly(2))
            ->method('ask')
            ->withConsecutive(['What is your choice?'], ['What is your choice?'])
            ->willReturnOnConsecutiveCalls(4, 6);
        $this->flashcardInteractiveCommand
            ->expects($this->once())
            ->method('stats');
        $this->flashcardInteractiveCommand
            ->expects($this->exactly(2))
            ->method('newLine');

        $this->assertEmpty($this->flashcardInteractiveCommand->handle());
    }

    /**
     * @test
     * @group flashcardInteractiveCommand
     * @covers FlashcardInteractiveCommand::handle
     */
    public function it_should_reset_flashcard_practices_when_the_choice_is_5()
    {
        $this->onlyMethods(['showMenu', 'reset', 'ask', 'newLine']);

        $this->flashcardInteractiveCommand
            ->expects($this->exactly(2))
            ->method('showMenu');
        $this->flashcardInteractiveCommand
            ->expects($this->exactly(2))
            ->method('ask')
            ->withConsecutive(['What is your choice?'], ['What is your choice?'])
            ->willReturnOnConsecutiveCalls(5, 6);
        $this->flashcardInteractiveCommand
            ->expects($this->once())
            ->method('reset');
        $this->flashcardInteractiveCommand
            ->expects($this->exactly(2))
            ->method('newLine');

        $this->assertEmpty($this->flashcardInteractiveCommand->handle());
    }

    /**
     * @test
     * @group flashcardInteractiveCommand
     * @covers FlashcardInteractiveCommand::handle
     */
    public function it_should_exit_when_the_choice_is_6()
    {
        $this->onlyMethods(['showMenu', 'ask', 'newLine']);

        $this->flashcardInteractiveCommand
            ->expects($this->once())
            ->method('showMenu');
        $this->flashcardInteractiveCommand
            ->expects($this->once())
            ->method('ask')
            ->with('What is your choice?')
            ->willReturn(6);
        $this->flashcardInteractiveCommand
            ->expects($this->once())
            ->method('newLine');

        $this->assertEmpty($this->flashcardInteractiveCommand->handle());
    }

    /**
     * @test
     * @group flashcardInteractiveCommand
     * @covers FlashcardInteractiveCommand::createFlashcard
     * @throws ReflectionException
     */
    public function it_should_create_a_flashcard()
    {
        $this->onlyMethods(['ask', 'info']);

        $question = $this->faker->text;
        $answer = $this->faker->text;

        $this->flashcardInteractiveCommand
            ->expects($this->exactly(2))
            ->method('ask')
            ->withConsecutive(['Ask a question?'], ['Provide the correct answer to your question?'])
            ->willReturnOnConsecutiveCalls($question, $answer);
        $this->flashcardRepository
            ->expects($this->once())
            ->method('save')
            ->with($question, $answer);
        $this->flashcardInteractiveCommand
            ->expects($this->once())
            ->method('info')
            ->with('Flashcard created successfully!');

        $this->assertEmpty($this->invokeMethod($this->flashcardInteractiveCommand, 'createFlashcard'));
    }

    /**
     * @test
     * @group flashcardInteractiveCommand
     * @covers FlashcardInteractiveCommand::createFlashcard
     * @throws ReflectionException
     */
    public function it_should_not_create_a_flashcard_when_exception()
    {
        $this->onlyMethods(['ask', 'error']);

        $this->flashcardInteractiveCommand
            ->expects($this->exactly(2))
            ->method('ask')
            ->withConsecutive(['Ask a question?'], ['Provide the correct answer to your question?'])
            ->willReturnOnConsecutiveCalls('', '');
        $this->flashcardRepository
            ->expects($this->once())
            ->method('save')
            ->with('', '')
            ->willThrowException(new ReflectionException());
        $this->flashcardInteractiveCommand
            ->expects($this->once())
            ->method('error')
            ->with('Something went wrong!');

        $this->assertEmpty($this->invokeMethod($this->flashcardInteractiveCommand, 'createFlashcard'));
    }

    /**
     * @test
     * @group flashcardInteractiveCommand
     * @covers FlashcardInteractiveCommand::listAllFlashcards
     * @throws ReflectionException
     */
    public function it_should_list_all_flashcards()
    {
        $this->onlyMethods(['table']);

        $flashcards = Flashcard::factory()->count(2)->make();

        $this->flashcardRepository
            ->expects($this->once())
            ->method('all')
            ->with(['question', 'answer'])
            ->willReturn($flashcards);
        $this->flashcardInteractiveCommand
            ->expects($this->once())
            ->method('table')
            ->with(['Question', 'Answer'], $flashcards->toArray());

        $this->assertEmpty($this->invokeMethod($this->flashcardInteractiveCommand, 'listAllFlashcards'));
    }

    /**
     * @test
     * @group flashcardInteractiveCommand
     * @covers FlashcardInteractiveCommand::practice
     * @throws ReflectionException
     */
    public function it_should_not_practice_flashcards_when_question_is_empty()
    {
        $this->onlyMethods(['currentProgress', 'ask', 'error']);

        $this->flashcardInteractiveCommand
            ->expects($this->once())
            ->method('currentProgress');
        $this->flashcardInteractiveCommand
            ->expects($this->once())
            ->method('ask')
            ->with('Pick the question number you want to practice?')
            ->willReturn('');
        $this->flashcardInteractiveCommand
            ->expects($this->once())
            ->method('error')
            ->with('Something went wrong!');

        $this->assertEmpty($this->invokeMethod($this->flashcardInteractiveCommand, 'practice'));
    }

    /**
     * @test
     * @group flashcardInteractiveCommand
     * @covers FlashcardInteractiveCommand::practice
     * @throws ReflectionException
     */
    public function it_should_not_practice_flashcards_when_question_does_not_exists()
    {
        $this->onlyMethods(['currentProgress', 'ask', 'error']);

        $question = $this->faker->randomDigitNotNull;

        $this->flashcardInteractiveCommand
            ->expects($this->once())
            ->method('currentProgress');
        $this->flashcardInteractiveCommand
            ->expects($this->once())
            ->method('ask')
            ->with('Pick the question number you want to practice?')
            ->willReturn($question);
        $this->flashcardRepository
            ->expects($this->once())
            ->method('get')
            ->with($question)
            ->willReturn(null);
        $this->flashcardInteractiveCommand
            ->expects($this->once())
            ->method('error')
            ->with('The question number you selected is not listed in the flashcards!');

        $this->assertEmpty($this->invokeMethod($this->flashcardInteractiveCommand, 'practice'));
    }

    /**
     * @test
     * @group flashcardInteractiveCommand
     * @covers FlashcardInteractiveCommand::practice
     * @throws ReflectionException
     */
    public function it_should_not_practice_flashcards_when_question_is_already_answered_correctly()
    {
        $this->onlyMethods(['currentProgress', 'ask', 'error']);

        $flashcard = Flashcard::factory()->create();
        Practice::factory(['question_id' => $flashcard->id, 'is_answered_correctly' => 1])->create();

        $this->flashcardInteractiveCommand
            ->expects($this->once())
            ->method('currentProgress');
        $this->flashcardInteractiveCommand
            ->expects($this->once())
            ->method('ask')
            ->with('Pick the question number you want to practice?')
            ->willReturn($flashcard->id);
        $this->flashcardRepository
            ->expects($this->once())
            ->method('get')
            ->with($flashcard->id)
            ->willReturn($flashcard);
        $this->flashcardInteractiveCommand
            ->expects($this->once())
            ->method('error')
            ->with('The question number you has already been answered correctly!');

        $this->assertEmpty($this->invokeMethod($this->flashcardInteractiveCommand, 'practice'));
    }

    /**
     * @test
     * @group flashcardInteractiveCommand
     * @covers FlashcardInteractiveCommand::practice
     * @throws ReflectionException
     */
    public function it_should_not_practice_flashcards_when_answer_is_empty()
    {
        $this->onlyMethods(['currentProgress', 'ask', 'error']);

        $flashcard = Flashcard::factory()->create();

        $this->flashcardInteractiveCommand
            ->expects($this->once())
            ->method('currentProgress');
        $this->flashcardInteractiveCommand
            ->expects($this->exactly(2))
            ->method('ask')
            ->withConsecutive(
                ['Pick the question number you want to practice?'],
                ['Provide the correct answer to the question you picked?']
            )
            ->willReturnOnConsecutiveCalls($flashcard->id, '');
        $this->flashcardRepository
            ->expects($this->once())
            ->method('get')
            ->with($flashcard->id)
            ->willReturn($flashcard);
        $this->practiceRepository
            ->expects($this->once())
            ->method('save')
            ->with($flashcard->id, '')
            ->willThrowException(new ReflectionException());
        $this->flashcardInteractiveCommand
            ->expects($this->once())
            ->method('error')
            ->with('Something went wrong!');

        $this->assertEmpty($this->invokeMethod($this->flashcardInteractiveCommand, 'practice'));
    }

    /**
     * @test
     * @group flashcardInteractiveCommand
     * @covers FlashcardInteractiveCommand::practice
     * @throws ReflectionException
     */
    public function it_should_practice_flashcards()
    {
        $this->onlyMethods(['currentProgress', 'ask', 'error']);

        $answer = $this->faker->text;
        $flashcard = Flashcard::factory()->create();

        $this->flashcardInteractiveCommand
            ->expects($this->exactly(2))
            ->method('currentProgress');
        $this->flashcardInteractiveCommand
            ->expects($this->exactly(2))
            ->method('ask')
            ->withConsecutive(
                ['Pick the question number you want to practice?'],
                ['Provide the correct answer to the question you picked?']
            )
            ->willReturnOnConsecutiveCalls($flashcard->id, $answer);
        $this->flashcardRepository
            ->expects($this->once())
            ->method('get')
            ->with($flashcard->id)
            ->willReturn($flashcard);
        $this->practiceRepository
            ->expects($this->once())
            ->method('save')
            ->with($flashcard->id, $answer);

        $this->assertEmpty($this->invokeMethod($this->flashcardInteractiveCommand, 'practice'));
    }

    /**
     * @test
     * @group flashcardInteractiveCommand
     * @covers FlashcardInteractiveCommand::currentProgress
     * @throws ReflectionException
     */
    public function it_should_display_current_progress()
    {
        $this->onlyMethods(['table']);

        $flashcardWithStatus = $this->faker->sentences;

        $this->flashcardInteractiveService
            ->expects($this->once())
            ->method('getAllFlashcardsWithStatus')
            ->willReturn($flashcardWithStatus);
        $this->flashcardInteractiveCommand
            ->expects($this->once())
            ->method('table')
            ->with(['#', 'Question', 'Answer', 'Status'], $flashcardWithStatus);

        $this->assertEmpty($this->invokeMethod($this->flashcardInteractiveCommand, 'currentProgress'));
    }

    /**
     * @test
     * @group flashcardInteractiveCommand
     * @covers FlashcardInteractiveCommand::stats
     * @throws ReflectionException
     */
    public function it_should_display_stats()
    {
        $this->onlyMethods(['info', 'line']);

        $stats = [
            'totalQuestions' => $this->faker->randomDigitNotNull,
            'percentAnswers' => $this->faker->randomDigitNotNull,
            'percentCorrectAnswers' => $this->faker->randomDigitNotNull,
        ];

        $this->flashcardInteractiveService
            ->expects($this->once())
            ->method('getFlashcardStats')
            ->willReturn($stats);
        $this->flashcardInteractiveCommand
            ->expects($this->exactly(3))
            ->method('info')
            ->withConsecutive(['Total Questions'], ['Total Answers'], ['Total Correct Answers']);
        $this->flashcardInteractiveCommand
            ->expects($this->exactly(3))
            ->method('line')
            ->withConsecutive([$stats['totalQuestions']], [$stats['percentAnswers']], [$stats['percentCorrectAnswers']]);

        $this->assertEmpty($this->invokeMethod($this->flashcardInteractiveCommand, 'stats'));
    }

    /**
     * @test
     * @group flashcardInteractiveCommand
     * @covers FlashcardInteractiveCommand::reset
     * @throws ReflectionException
     */
    public function it_should_display_reset_all_practices()
    {
        $this->onlyMethods(['info']);

        $this->practiceRepository
            ->expects($this->once())
            ->method('truncate');
        $this->flashcardInteractiveCommand
            ->expects($this->once())
            ->method('info')
            ->with('Reset successfully!');

        $this->assertEmpty($this->invokeMethod($this->flashcardInteractiveCommand, 'reset'));
    }

    /**
     * @test
     * @group flashcardInteractiveCommand
     * @covers FlashcardInteractiveCommand::showMenu
     * @throws ReflectionException
     */
    public function it_should_display_menu()
    {
        $this->onlyMethods(['info']);

        $this->flashcardInteractiveCommand
            ->expects($this->exactly(6))
            ->method('info')
            ->withConsecutive(
                ['1. Create a flashcard'],
                ['2. List all flashcards'],
                ['3. Practice'],
                ['4. Stats'],
                ['5. Reset'],
                ['6. Exit'],
            );

        $this->assertEmpty($this->invokeMethod($this->flashcardInteractiveCommand, 'showMenu'));
    }
}
