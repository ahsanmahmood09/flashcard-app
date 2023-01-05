<?php

namespace App\Repositories;

use App\Models\Practice;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface PracticeRepositoryInterface
 * @package App\Repositories
 */
interface PracticeRepositoryInterface
{
    /**
     * @param int $questionId
     * @param string $answer
     * @param bool $isAnsweredCorrectly
     * @return Practice
     */
    public function save(int $questionId, string $answer, bool $isAnsweredCorrectly): Practice;

    /**
     * @param array $params
     * @return Collection
     */
    public function all(array $params = []): Collection;

    /**
     * @return void
     */
    public function truncate(): void;
}
