<?php

namespace App\Repositories;

use App\Models\Debate;
use App\Models\Question;

class QuestionRepository
{
    public function randomQuestion()
    {
        $debate_id = Debate::where('status', 'open')->inRandomOrder()->first()->id;
        return Question::where('debate_id', $debate_id)
            ->where('is_free', true)
            ->where('status', 'open')
            ->inRandomOrder()->first();
    }
}