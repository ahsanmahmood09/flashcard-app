<?php

namespace App\Repositories\Eloquent;

use App\Models\Practice;
use App\Repositories\PracticeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class PracticeRepository
 * @package App\Repositories\Eloquent
 */
class PracticeRepository implements PracticeRepositoryInterface
{
    /**
     * @param int $questionId
     * @param string $answer
     * @param bool $isAnsweredCorrectly
     * @return Practice
     */
    public function save(int $questionId, string $answer, bool $isAnsweredCorrectly): Practice
    {
        return Practice::updateOrCreate(
            ['question_id' => $questionId],
            ['question_id' => $questionId, 'answer' => $answer, 'is_answered_correctly' => $isAnsweredCorrectly],
        );
    }

    /**
     * @param array $params
     * @return Collection
     */
    public function all(array $params = []): Collection
    {
        return Practice::all($params);
    }

    /**
     * @return void
     */
    public function truncate(): void
    {
        Practice::truncate();
    }
}
