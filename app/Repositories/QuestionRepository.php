<?php

namespace App\Repositories;

use App\Models\Question;

class QuestionRepository
{
    public function randomQuestion()
    {
        $debate_id = rand(1, 1);
        $questions = Question::where('debate_id', $debate_id)->where('is_free', true)->inRandomOrder()->get();
        foreach ($questions as $question) {
            # Only show questions for which tags have been prepared
            if ($question->tags()->count() >= 5) {
                return $question;
            }
        }
    }
}