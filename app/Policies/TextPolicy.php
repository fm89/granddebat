<?php

namespace App\Policies;

use App\Models\Question;
use App\Models\Text;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TextPolicy
{
    use HandlesAuthorization;

    public const MIN_SCORE_PER_QUESTION = 500;

    public function create(User $user, Question $question)
    {
        return $user->scores['questions'][$question->id] ?? 0 >= self::MIN_SCORE_PER_QUESTION;
    }

    public function update(User $user, Text $text)
    {
        return $text->user_id == $user->id;
    }
}
