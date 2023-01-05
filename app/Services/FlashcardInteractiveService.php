<?php

namespace App\Services;

use App\Repositories\FlashcardRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class FlashcardInteractiveService
 * @package App\Services
 */
class FlashcardInteractiveService   
{
    /**
     * @var FlashcardRepositoryInterface $flashcardRepository
     */
    private FlashcardRepositoryInterface $flashcardRepository;

    /**
     * FlashcardService constructor.
     *
     * @param FlashcardRepositoryInterface $flashcardRepository
     */
    public function __construct(FlashcardRepositoryInterface $flashcardRepository)
    {
        $this->flashcardRepository = $flashcardRepository;
    }

    /**
     * @return array
     */
    public function getAllFlashcardsWithStatus(): array
    {
        $correct = 0;
        $flashcardsWithStatus = [];
        $flashcards = $this->flashcardRepository->all(['id', 'question', 'answer']);

        $flashcards->each(
            function ($flashcard, $index) use (&$flashcardsWithStatus, &$correct) {
                $practice = $flashcard->practice;

                $flashcardsWithStatus[$index]['index'] = $flashcard->id;
                $flashcardsWithStatus[$index]['question'] = $flashcard->question;
                $flashcardsWithStatus[$index]['answer'] = $flashcard->answer;

                if ($practice) {
                    if ($practice->answer === $flashcard->answer) {
                        $flashcardsWithStatus[$index]['status'] = 'Correct';
                        $correct++;
                    } else {
                        $flashcardsWithStatus[$index]['status'] = 'Incorrect';
                    }

                    return;
                }

                $flashcardsWithStatus[$index]['status'] = 'Not answered';
            }
        );

        return array_merge(
            $flashcardsWithStatus,
            $this->addFooterToProgressTable($flashcards, $correct, count($flashcardsWithStatus))
        );
    }

    /**
     * @return array
     */
    public function getFlashcardStats(): array
    {
        $answers = 0;
        $correct = 0;
        $flashcardsStats = [];
        $flashcards = $this->flashcardRepository->all(['id', 'question', 'answer']);

        $flashcards->each(
            function ($flashcard) use (&$answers, &$correct) {
                $practice = $flashcard->practice;

                if ($practice) {
                    if ($practice->answer === $flashcard->answer) {
                        $correct++;
                    }

                    $answers++;
                }
            }
        );

        $flashcardsStats['totalQuestions'] = $flashcards->count();
        $flashcardsStats['percentAnswers'] = ($answers / $flashcards->count() * 100) . '%';
        $flashcardsStats['percentCorrectAnswers'] = ($correct / $flashcards->count() * 100) . '%';

        return $flashcardsStats;
    }

    /**
     * @param Collection $flashcards
     * @param int $correct
     * @param int $index
     * @return array
     */
    private function addFooterToProgressTable(Collection $flashcards, int $correct, int $index): array
    {
        $flashcardsWithStatus[$index]['index'] = '';
        $flashcardsWithStatus[$index]['question'] = '';
        $flashcardsWithStatus[$index]['answer'] = '';
        $flashcardsWithStatus[$index]['status'] = ($correct / $flashcards->count()) * 100 . '%';

        return $flashcardsWithStatus;
    }
}
