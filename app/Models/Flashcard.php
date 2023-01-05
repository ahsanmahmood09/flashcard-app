<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Flashcard
 * @package App\Models
 *
 * @property string id
 * @property string question
 * @property string answer
 *
 * @property Practice practice
 */
class Flashcard extends Model
{
    use HasFactory;

    /**
     * @var string $table
     */
    protected $table = 'flashcards';

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'question',
        'answer',
    ];

    /**
     * @return HasOne
     */
    public function practice(): HasOne
    {
        return $this->hasOne(Practice::class, 'question_id');
    }
}
