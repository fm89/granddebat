<?php

namespace App\Http\Controllers;


use App\Logic\Stats;
use App\Models\Action;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MyOverviewController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();
        $ongoing = [];
        $done = [];
        if ($user != null) {
            $counts = Action::join('responses', 'responses.id', 'actions.response_id')
                ->select('question_id', DB::raw('COUNT(DISTINCT clean_value_group_id) AS count'))
                ->where('actions.user_id', $user->id)
                ->groupBy('question_id')
                ->pluck('count', 'question_id')
                ->all();
            foreach ($counts as $question_id => $count) {
                $question = Question::find($question_id);
                if ($question->status == 'open') {
                    if ($count < 300) {
                        $ongoing[] = [
                            'question' => $question,
                            'count' => $count,
                            'rank' => $question->debate_id * 1000 + $question->order,
                        ];
                    } else {
                        $done[] = [
                            'question' => $question,
                            'count' => $count,
                            'stats' => Stats::getForUserQuestion($user, $question, $count),
                            'rank' => $question->debate_id * 1000 + $question->order,
                        ];
                    }
                }
            }
            $ongoing = collect($ongoing)->sort(function ($a, $b) { return $a['rank'] < $b['rank'] ? -1 : (($a['rank'] == $b['rank']) ? 0 : 1); })->toArray();
            $done = collect($done)->sort(function ($a, $b) { return $a['rank'] < $b['rank'] ? -1 : (($a['rank'] == $b['rank']) ? 0 : 1); })->toArray();
        }
        return view('users.my-overview', compact('done', 'ongoing', 'user'));
    }
}
