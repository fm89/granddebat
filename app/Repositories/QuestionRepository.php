<?php

namespace App\Repositories;

use App\Models\Debate;
use App\Models\Question;

class QuestionRepository
{
    public function randomQuestion($user, $debate = null)
    {
        $current_score = $user == null ? 0 : $user->scores['total'];
        if ($debate == null) {
            $debate = Debate::where('status', 'open')
                ->orderByRaw('priority DESC, RANDOM()')
                ->first();
        }
        return Question::where('debate_id', $debate->id)
            ->where('is_free', true)
            ->where('status', 'open')
            ->where('minimal_score', '<=', $current_score)
            ->orderByRaw('priority DESC, RANDOM()')
            ->first();
    }
}