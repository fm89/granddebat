<?php

namespace App\Console\Commands;

use App\Logic\Priority;
use App\Logic\Weights;
use App\Models\Question;
use App\Models\Response;
use App\Models\Result;
use Illuminate\Console\Command;

class ComputeResults extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:compute_results';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compute the set of tags validated for each response';

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
        Result::truncate();
        $questions = Question::all();
        foreach ($questions as $question) {
            $this->info("\n\nHandling question " . $question->id);
            $this->handleQuestion($question);
        }
    }

    private function handleQuestion(Question $question)
    {
        $n1 = Weights::getN1ByAuthorId($question);
        $p2 = Weights::getP2ByGroupId($question);
        $responses = Response::with(['actions', 'proposal'])->where('question_id', $question->id)->whereHas('actions')->get();
        $this->info('Preparing to process ' . count($responses) . ' responses');
        $bar = $this->output->createProgressBar(count($responses));
        $bar->start();
        foreach ($responses as $response) {
            $priority = Priority::getFor($response);
            if ($priority < 0) {
                $actions = $response->actions;
                $users_count = $actions->map(function ($action) { return $action->user_id; })->unique()->count();
                $tags = $actions->map(function ($action) { return $action->tag_id; })->unique()->all();
                $tagsOk = [];
                foreach ($tags as $tag) {
                    $users_agree = $actions->filter(function ($action) use ($tag) { return $action->tag_id == $tag; })->count();
                    $users_disagree = $users_count - $users_agree;
                    if ($users_agree > $users_disagree) {
                        $tagsOk[] = $tag;
                    }
                }
                $weight = $p2[$response->clean_value_group_id] / $n1[$response->proposal->author_id];
                if (count($tagsOk) > 0) {
                    foreach ($tagsOk as $tag) {
                        $result = new Result();
                        $result->response_id = $response->id;
                        $result->tag_id = $tag;
                        $result->weight = $weight;
                        $result->save();
                    }
                } else {
                    $result = new Result();
                    $result->response_id = $response->id;
                    $result->tag_id = null;
                    $result->weight = $weight;
                    $result->save();
                }
            }
            $bar->advance();
        }
        $bar->finish();
    }
}
