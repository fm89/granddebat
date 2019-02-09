<?php

namespace App\Repositories;

use App\Models\Question;

class QuestionRepository
{
    public function randomQuestion()
    {
        $debate_id = rand(1, 1);
        return Question::where('debate_id', $debate_id)->where('is_free', true)->inRandomOrder()->first();
    }
}