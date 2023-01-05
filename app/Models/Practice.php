<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Practice
 * @package App\Models
 *
 * @property int question
 * @property string answer
 * @property bool is_answered_correctly
 *
 * @property User user
 * @property Flashcard flashcard
 */
class Practice extends Model
{
    use HasFactory;

    /**
     * @var string $table
     */
    protected $table = 'practices';

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'question_id',
        'answer',
        'is_answered_correctly',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function flashcard(): BelongsTo
    {
        return $this->belongsTo(Flashcard::class);
    }
}
