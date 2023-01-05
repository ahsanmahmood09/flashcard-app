<?php

namespace App\Repositories;

use App\Models\Flashcard;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface FlashcardRepositoryInterface
 * @package App\Repositories
 */
interface FlashcardRepositoryInterface
{
    /**
     * @param string $question
     * @param string $answer
     * @return Flashcard
     */
    public function save(string $question, string $answer): Flashcard;

    /**
     * @param array $params
     * @return Collection
     */
    public function all(array $params = []): Collection;

    /**
     * @param int $id
     * @return Flashcard|null
     */
    public function get(int $id): ?Flashcard;

    /**
     * @return void
     */
    public function truncate(): void;
}
