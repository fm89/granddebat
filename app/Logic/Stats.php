<?php

namespace App\Logic;


use App\Models\Action;
use App\Models\Response;
use App\Models\Result;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class Stats
{
    public static function getForUserQuestion($user, $question, $countUser)
    {
        # Computer users stats for question.
        # We apply a small correction linked to the fact that the user may have not seen the most common verbatims
        # So, we append to his tags, the common tag results for the verbatims representing more than 0.5% of the data.
        $total = $question->responses()->count();
        $mostCommon = Response::select(DB::raw('COUNT(*) AS "count"'), DB::raw('MIN(id) AS "min_id"'))
            ->groupBy('clean_value_group_id')
            ->where('question_id', $question->id)
            ->havingRaw('COUNT(*) > ?', [floor(0.005 * $total)])
            ->pluck('count', 'min_id')
            ->all();
        $mostCommonSum = 0;
        $tagCounts = [];
        foreach ($mostCommon as $min_id => $count) {
            $mostCommonSum += $count;
            $results = Result::where('response_id', $min_id)->get();
            foreach ($results as $result) {
                $tagCounts[$result->tag_id] = ($tagCounts[$result->tag_id] ?? 0) + $count;
            }
        }
        $ratio = ($total - $mostCommonSum) / $countUser;
        $userActions = Action::join('responses', 'responses.id', 'actions.response_id')
            ->select('tag_id')
            ->groupBy('clean_value_group_id', 'tag_id')
            ->where('user_id', $user->id)
            ->where('question_id', $question->id)
            ->get();
        foreach ($userActions as $userAction) {
            $tagCounts[$userAction->tag_id] = ($tagCounts[$userAction->tag_id] ?? 0) + $ratio;
        }
        $tags = Tag::whereIn('id', array_keys($tagCounts))->get()->keyBy('id');
        $stats = [];
        foreach ($tagCounts as $tagId => $tagCount) {
            $stats[$tags[$tagId]->getLabel()] = round(100 * $tagCount / $total);
        }
        arsort($stats);
        if (count($stats) > 15) {
            $stats = array_slice($stats, 0, 15);
        }
        return $stats;
    }
}