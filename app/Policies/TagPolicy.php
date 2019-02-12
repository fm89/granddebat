<?php

namespace App\Policies;

use App\Models\Tag;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Tag $tag)
    {
        return $tag->user_id == $user->id || $user->role == 'admin';
    }

    public function delete(User $user, Tag $tag)
    {
        return $this->update($user, $tag) && $tag->actions()->doesntExist();
    }
}
