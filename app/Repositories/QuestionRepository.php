<?php

namespace App\Repositories;

use App\Models\Debate;
use App\Models\Question;

class QuestionRepository
{
    public function randomQuestion($user)
    {
        $current_score = $user == null ? 0 : $user->scores['total'];
        $debate_id = Debate::where('status', 'open')->inRandomOrder()->first()->id;
        return Question::where('debate_id', $debate_id)
            ->where('is_free', true)
            ->where('status', 'open')
            ->where('minimal_score', '<=', $current_score)
            ->inRandomOrder()->first();
    }
}