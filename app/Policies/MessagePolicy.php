<?php

namespace App\Policies;

use App\Models\Message;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MessagePolicy
{
    use HandlesAuthorization;

    public function show(User $user, Message $message)
    {
        return $message->user_id == $user->id;
    }
}
