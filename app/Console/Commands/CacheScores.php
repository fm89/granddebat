<?php

namespace App\Console\Commands;

use App\Models\Action;
use App\Models\Question;
use App\Models\Response;
use App\Models\Tag;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CacheScores extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:cache_scores';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rebuilds scores data for each user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $questions = Question::pluck('debate_id', 'id')->all();
        foreach (User::get() as $user) {
            $this->info('Handling user ' . $user->id);
            $quality = $this->getUserQuality($user);
            $per_question = Action::join('responses', 'responses.id', 'actions.response_id')
                ->groupBy('question_id')
                ->where('user_id', $user->id)
                ->select('question_id', DB::raw('COUNT(DISTINCT clean_value_group_id) AS values'))
                ->pluck('values', 'question_id')
                ->all();
            $per_debate = [1 => 0, 2 => 0, 3 => 0, 4 => 0];
            $total = 0;
            foreach ($per_question as $question_id => $values) {
                $debate_id = $questions[$question_id];
                $per_debate[$debate_id] = $per_debate[$debate_id] + $values;
                $total += $values;
            }
            $scores = [
                'total' => $total,
                'debates' => $per_debate,
                'questions' => $per_question,
                'quality' => $quality,
            ];
            $user->scores = $scores;
            $user->save();
        }
    }

    private function getUserQuality($user)
    {
        // Consider one response per group for which we know the community truth and which the user has tagged
        $responseIds = Response::select(DB::raw('MIN(id) AS "id"'))
            ->whereHas('results')
            ->whereHas('actions', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->groupBy('clean_value_group_id')
            ->pluck('id');
        $responses = Response::with(['actions', 'results'])->whereIn('id', $responseIds)->get();
        $falseNegative = 0;
        $truePositive = 0;
        $falsePositive = 0;
        $customTagIds = Tag::where('user_id', $user->id)->pluck('id')->toArray();
        foreach ($responses as $response) {
            $userTags = $response->actions
                ->filter(function ($action) use ($user, $customTagIds) {
                    # Don't penalize the precision of users who use their custom tags
                    return ($action->user_id == $user->id) && (!in_array($action->tag_id, $customTagIds));
                })
                ->map(function ($action) {
                    return $action->tag_id;
                })
                ->toArray();
            $truthTags = $response->results
                ->map(function ($result) {
                    return $result->tag_id;
                })
                ->toArray();
            foreach ($userTags as $userTag) {
                if (in_array($userTag, $truthTags)) {
                    $truePositive++;
                } else {
                    $falsePositive++;
                }
            }
            foreach ($truthTags as $truthTag) {
                if (!in_array($truthTag, $userTags)) {
                    $falseNegative++;
                }
            }
        }
        if ($truePositive >= 10) {
            $precision = $truePositive / ($truePositive + $falsePositive);
            $recall = $truePositive / ($truePositive + $falseNegative);
            return [
                'volume' => $truePositive,
                'precision' => $precision,
                'recall' => $recall,
                'F1-score' => 2 * $precision * $recall / ($precision + $recall),
            ];
        } else {
            return [
                'volume' => $truePositive,
                'precision' => null,
                'recall' => null,
                'F1-score' => null,
            ];
        }
    }
}
