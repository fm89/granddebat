<?php

namespace App\Repositories;

use App\Models\Question;

class ResponseRepository
{
    public function randomResponse(Question $question, $user)
    {
        # First try to find a response which has not been tagged by the current user
        $query = $question->responses();
        if ($user != null) {
            $query = $query->whereDoesntHave('actions', function ($query) use ($user) {
                    return $query->where('user_id', '=', $user->id);
            });
        }
        $response = $query->orderByRaw('priority DESC, RANDOM()')->first();

        # Else return a random response
        if ($response == null) {
            $response = $question->responses()
                ->inRandomOrder()
                ->first();
        }

        return $response;
    }
}