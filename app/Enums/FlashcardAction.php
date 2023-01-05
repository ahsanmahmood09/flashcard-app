<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

/**
 * Class FlashcardAction
 * @package App\Enums
 */
abstract class FlashcardAction extends Enum
{
    const CREATE_A_FLASHCARD = 1;
    const LIST_ALL_FLASHCARDS = 2;
    const PRACTICE = 3;
    const STATS = 4;
    const RESET = 5;
    const EXIT = 6;
}
