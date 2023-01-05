<?php

namespace App\Repositories\Eloquent;

use App\Models\Flashcard;
use App\Repositories\FlashcardRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class FlashcardRepository
 * @package App\Repositories\Eloquent
 */
class FlashcardRepository implements FlashcardRepositoryInterface
{
    /**
     * @param string $question
     * @param string $answer
     * @return Flashcard
     */
    public function save(string $question, string $answer): Flashcard
    {
        return Flashcard::updateOrCreate(['question' => $question], ['question' => $question, 'answer' => $answer]);
    }

    /**
     * @param array $params
     * @return Collection
     */
    public function all(array $params = []): Collection
    {
        return Flashcard::all($params);
    }

    /**
     * @param int $id
     * @return Flashcard|null
     */
    public function get(int $id): ?Flashcard
    {
        return Flashcard::find($id);
    }

    /**
     * @return void
     */
    public function truncate(): void
    {
        Flashcard::truncate();
    }
}
