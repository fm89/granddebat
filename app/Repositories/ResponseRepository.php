<?php

namespace App\Repositories;

use App\Models\Question;

class ResponseRepository
{
    public function next(Question $question, $user)
    {
        if ($user == null) {
            return $this->random($question);
        } else {
            if ($question->status != 'open') {
                // While admins prepare default tags, it is important to navigate randomly without the priority ranking
                // Non admin users also should be able to navigate through the whole set (and not just top priority)
                $response = $this->untagged($question, $user)->inRandomOrder()->first();
            } else {
                // Don't show the user a response he skipped before (to avoid recurring loops)
                $response = $this->untagged($question, $user)
                    ->whereDoesntHave('skips', function ($query) use ($user) {
                        $query->where('user_id', $user->id);
                    })
                    ->orderByRaw('priority DESC, RANDOM()')
                    ->first();
            }
            if ($response == null) {
                return $this->random($question);
            } else {
                return $response;
            }
        }
    }

    private function random(Question $question)
    {
        return $question->responses()->inRandomOrder()->first();
    }

    private function untagged(Question $question, $user)
    {
        return $question->responses()->whereDoesntHave('actions', function ($query) use ($user) {
            return $query->where('user_id', '=', $user->id);
        });
    }
}