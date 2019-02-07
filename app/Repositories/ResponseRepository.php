<?php

namespace App\Repositories;

use App\Models\Question;

class ResponseRepository
{
    public function randomResponse(Question $question)
    {
        # First try to find a response without any linked tag
        $response = $question->responses()->whereDoesntHave('actions')->inRandomOrder()->first();
        # Else return a random response
        if ($response == null) {
            $response = $question->responses()->inRandomOrder()->first();
        }
        return $response;
    }
}