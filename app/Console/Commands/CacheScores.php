<?php

namespace App\Console\Commands;

use App\Models\Action;
use App\Models\Question;
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
            $per_question = Action::join('responses', 'responses.id', 'actions.response_id')
                ->groupBy('question_id')
                ->where('user_id', $user->id)
                ->select('question_id', DB::raw('COUNT(DISTINCT value) AS values'))
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
            ];
            $user->scores = $scores;
            $user->save();
        }
    }
}
