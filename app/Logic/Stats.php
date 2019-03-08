<?php

namespace App\Logic;


use App\Models\Action;
use App\Models\Tag;

class Stats
{
    public static function getForUserQuestion($user, $question)
    {
        $userActions = Action::join('responses', 'responses.id', 'actions.response_id')
            ->select('tag_id')
            ->groupBy('clean_value_group_id', 'tag_id')
            ->where('user_id', $user->id)
            ->where('question_id', $question->id)
            ->get();
        $tagCounts = [];
        foreach ($userActions as $userAction) {
            $tagCounts[$userAction->tag_id] = ($tagCounts[$userAction->tag_id] ?? 0) + 1;
        }
        $tags = Tag::whereIn('id', array_keys($tagCounts))->get()->keyBy('id');
        $stats = [];
        foreach ($tagCounts as $tagId => $tagCount) {
            $stats[$tags[$tagId]->getLabel()] = $tagCount;
        }
        arsort($stats);
        if (count($stats) > 15) {
            $stats = array_slice($stats, 0, 15);
        }
        return $stats;
    }
}