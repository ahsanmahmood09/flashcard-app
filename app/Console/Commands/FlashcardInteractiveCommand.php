<?php

namespace App\Console\Commands;

use App\Enums\FlashcardAction;
use App\Repositories\FlashcardRepositoryInterface;
use App\Repositories\PracticeRepositoryInterface;
use App\Services\FlashcardInteractiveService;
use Illuminate\Console\Command;
use Throwable;

class FlashcardInteractiveCommand extends Command
{
    /**
     * @var FlashcardInteractiveService $flashcardInteractiveService
     */
    private FlashcardInteractiveService $flashcardInteractiveService;

    /**
     * @var FlashcardRepositoryInterface $flashcardRepository
     */
    private FlashcardRepositoryInterface $flashcardRepository;

    /**
     * @var PracticeRepositoryInterface $practiceRepository
     */
    private PracticeRepositoryInterface $practiceRepository;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:interactive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command shows the flashcard interactive menu';

    /**
     * Create a new command instance.
     *
     * @param FlashcardInteractiveService $flashcardInteractiveService
     * @param FlashcardRepositoryInterface $flashcardRepository
     * @param PracticeRepositoryInterface $practiceRepository
     */
    public function __construct(
        FlashcardInteractiveService $flashcardInteractiveService,
        FlashcardRepositoryInterface $flashcardRepository,
        PracticeRepositoryInterface $practiceRepository
    ) {
        $this->flashcardInteractiveService = $flashcardInteractiveService;
        $this->flashcardRepository = $flashcardRepository;
        $this->practiceRepository = $practiceRepository;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $choice = 0;

        while ($choice != FlashcardAction::EXIT) {
            $this->showMenu();
            $choice = $this->ask('What is your choice?');

            switch ($choice) {
                case FlashcardAction::CREATE_A_FLASHCARD:
                    $this->createFlashcard();
                    break;

                case FlashcardAction::LIST_ALL_FLASHCARDS:
                    $this->listAllFlashcards();
                    break;

                case FlashcardAction::PRACTICE:
                    $this->practice();
                    break;

                case FlashcardAction::STATS:
                    $this->stats();
                    break;

                case FlashcardAction::RESET:
                    $this->reset();
                    break;
            }

            $this->newLine();
        }
    }

    /**
     * @return void
     */
    protected function createFlashcard(): void
    {
        $question = $this->ask('Ask a question?');
        $answer = $this->ask('Provide the correct answer to your question?');

        try {
            $this->flashcardRepository->save($question, $answer);
            $this->info('Flashcard created successfully!');
        } catch (Throwable $exception) {
            $this->error('Something went wrong!');
        }
    }

    /**
     * @return void
     */
    protected function listAllFlashcards(): void
    {
        $this->table(['Question', 'Answer'], $this->flashcardRepository->all(['question', 'answer'])->toArray());
    }

    /**
     * @return void
     */
    protected function practice(): void
    {
        $this->currentProgress();
        $question = $this->ask('Pick the question number you want to practice?');

        if (!$question) {
            $this->error('Something went wrong!');
            return;
        }

        $flashcard = $this->flashcardRepository->get($question);

        if (!$flashcard) {
            $this->error('The question number you selected is not listed in the flashcards!');
            return;
        }

        if ($flashcard->practice && $flashcard->practice->is_answered_correctly) {
            $this->error('The question number you has already been answered correctly!');
            return;
        }

        $answer = $this->ask('Provide the correct answer to the question you picked?');

        try {
            $this->practiceRepository->save($flashcard->id, $answer, $flashcard->answer === $answer);
        } catch (Throwable $exception) {
            $this->error('Something went wrong!');
            return;
        }

        $this->currentProgress();
    }

    /**
     * @return void
     */
    protected function currentProgress(): void
    {
        $flashcardsWithStatus = $this->flashcardInteractiveService->getAllFlashcardsWithStatus();
        $this->table(['#', 'Question', 'Answer', 'Status'], $flashcardsWithStatus);
    }

    /**
     * @return void
     */
    protected function stats(): void
    {
        $stats = $this->flashcardInteractiveService->getFlashcardStats();

        $this->info('Total Questions');
        $this->line($stats['totalQuestions']);
        $this->info('Total Answers');
        $this->line($stats['percentAnswers']);
        $this->info('Total Correct Answers');
        $this->line($stats['percentCorrectAnswers']);
    }

    /**
     * @return void
     */
    protected function reset(): void
    {
        $this->practiceRepository->truncate();
        $this->info('Reset successfully!');
    }

    /**
     * @return void
     */
    protected function showMenu(): void
    {
        $this->info('1. Create a flashcard');
        $this->info('2. List all flashcards');
        $this->info('3. Practice');
        $this->info('4. Stats');
        $this->info('5. Reset');
        $this->info('6. Exit');
    }
}
