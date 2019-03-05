<?php

namespace App\Policies;

use App\Models\Question;
use App\Models\Tag;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
{
    use HandlesAuthorization;

    public function create(User $user, Question $question)
    {
        return ($user != null) && (($user->role === 'admin') || ($user->scores['questions'][$question->id] ?? 0) >= 50);
    }

    public function inject(User $user, Tag $tag)
    {
        return ($user != null) && ($user->id === 1) && ($tag->user_id === null);
    }

    public function update(User $user, Tag $tag)
    {
        return $tag->user_id == $user->id || $user->role == 'admin';
    }

    public function delete(User $user, Tag $tag)
    {
        return $this->update($user, $tag) && ($tag->actions()->doesntExist() || $tag->user_id === $user->id);
    }
}
