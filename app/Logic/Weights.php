<?php

namespace App\Logic;


use App\Models\Response;
use Illuminate\Support\Facades\DB;

/**
 * See doc/MATH.md
 */
class Weights
{
    public static function getN1ByAuthorId($question)
    {
        return Response::join('proposals', 'proposals.id', 'responses.proposal_id')
            ->select('proposals.author_id', DB::raw('COUNT(*) AS counts'))
            ->where('responses.question_id', $question->id)
            ->groupBy('proposals.author_id')
            ->pluck('counts', 'author_id');
    }

    public static function getP2ByGroupId($question)
    {
        $countAllByGroup = Response::select('clean_value_group_id', DB::raw('COUNT(*) AS counts'))
            ->groupBy('clean_value_group_id')
            ->where('question_id', $question->id)
            ->pluck('counts', 'clean_value_group_id');
        $countWithActionsByGroup = Response::select('clean_value_group_id', DB::raw('COUNT(*) AS counts'))
            ->groupBy('clean_value_group_id')
            ->where('question_id', $question->id)
            ->whereHas('actions')
            ->pluck('counts', 'clean_value_group_id');
        $totalResponses = $question->responses()->count();
        $singleResponses = self::countOnes($countAllByGroup);
        $singleResponsesWithActions = self::countOnes($countWithActionsByGroup);
        if ($singleResponsesWithActions < $singleResponses) {
            # See doc/MATH.md
            $draws = log(1 - $singleResponsesWithActions / $singleResponses) / log(1 - 1 / $singleResponses) * $totalResponses / $singleResponses;
        } else {
            # Infinite number of draws
            $draws = -1;
        }
        $weights = [];
        foreach ($countWithActionsByGroup as $group_id => $count) {
            # See doc/MATH.md
            $weights[$group_id] = $draws <= 0 ? 1.0 : 1.0 / (1.0 - pow(1 - $count / $totalResponses, $draws));
        }
        return $weights;
    }

    private static function countOnes($array)
    {
        $result = 0;
        foreach ($array as $key => $value) {
            if ($value === 1) {
                $result += 1;
            }
        }
        return $result;
    }
}