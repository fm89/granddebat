<?php

namespace App\Console\Commands;

use App\Models\Question;
use App\Models\Response;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RefreshPriorityQuestions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:refresh_priority_questions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refreshes the value of the priority field for questions';

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
        $finished = Response::join('actions', 'actions.response_id', 'responses.id')
            ->select('responses.question_id', DB::raw('COUNT(DISTINCT (responses.clean_value_group_id)) AS counts'))
            ->where('responses.priority', '<', 0)
            ->groupBy('responses.question_id')
            ->pluck('counts', 'responses.question_id');
        $totals = Response::select('responses.question_id', DB::raw('COUNT(DISTINCT (responses.clean_value_group_id)) AS counts'))
            ->groupBy('responses.question_id')
            ->pluck('counts', 'responses.question_id');
        foreach ($totals as $question_id => $q_total) {
            $q_finished = $finished[$question_id] ?? 0;
            $question = Question::find($question_id);
            $question->priority = 1000 - ceil(1000.0 * $q_finished / $q_total);
            $question->save();
        }
    }
}
