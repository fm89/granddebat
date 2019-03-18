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
            $query = Debate::where('status', 'open');
            if ($user != null) {
                $query = $query->orderByRaw('priority DESC, RANDOM()');
            } else {
                $query = $query->orderByRaw('RANDOM()');
            }
            $debate = $query->first();
        }
        $query = Question::where('debate_id', $debate->id)
            ->where('is_free', true)
            ->where('status', 'open')
            ->where('minimal_score', '<=', $current_score);
        if ($user != null) {
            $query = $query->orderByRaw('priority DESC, RANDOM()');
        } else {
            $query = $query->orderByRaw('RANDOM()');
        }
        return $query->first();
    }

    public function listOfDebate($debate_id)
    {
        $questions = Question::where('debate_id', $debate_id)
            ->where('is_free', true)
            ->orderByRaw('status ASC, minimal_score ASC, RANDOM()')
            ->get();
        foreach ($questions as $question) {
            if ($question->previous != null) {
                $question->text = $question->previous->text . ' ' . $question->text;
            }
        }
        return $questions;
    }
}