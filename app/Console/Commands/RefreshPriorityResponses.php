<?php

namespace App\Console\Commands;

use App\Models\Action;
use App\Models\Question;
use App\Models\Response;
use Illuminate\Console\Command;

class RefreshPriorityResponses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:refresh_priority_responses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refreshes the value of the priority field for responses';

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
        // Stop tagging if :
        // - 7 or more users gave their opinion (whatever is the outcome, classified or not)
        // - At least 3 users gave their opinion and for each tag mentioned at least once
        //     + let "A" be the number of users who assigned it and "B" be the number of users who did not assign it
        //     + we require that |A-B| >= 2 (qualified majority, allowing 3 vs 1, and 4 vs 2 victories

        $questions = Question::all();
        foreach ($questions as $question) {
            $this->info("\n\nHandling question " . $question->id);
            $this->handleQuestion($question);
        }
    }

    private function handleQuestion(Question $question)
    {
        $responses = Response::where('question_id', $question->id)
            ->whereHas('actions')->pluck('id');
        $this->info('Preparing to process ' . count($responses) . ' responses');
        $bar = $this->output->createProgressBar(count($responses));
        $bar->start();
        foreach ($responses as $response) {
            $this->handleResponse($response);
            $bar->advance();
        }
        $bar->finish();
    }

    private function handleResponse($response_id)
    {
        $response = Response::find($response_id);
        $actions = Action::where('response_id', $response_id)->get();
        $users_count = $actions->map(function ($action) { return $action->user_id; })->unique()->count();
        if ($users_count >= 7) {
            // Stop tagging if 7 users have given their opinion (whether they agree or not)
            $priority = $this->hasSemiConverged($actions, $users_count) ? -5 : -1;
        } elseif ($users_count < 3) {
            // Continue tagging if only 1 or 2 users have given their opinion
            $priority = 10;
        } else {
            // If 3 to 6 users have given their opinion
            $priority = $this->hasConverged($actions, $users_count) ? -10 : 5;
        }
        if ($priority != $response->$priority) {
            // Save a few UPDATE queries
            $response->priority = $priority;
            $response->save();
        }
    }

    private function hasConverged($actions, $users_count)
    {
        $tags = $actions->map(function ($action) { return $action->tag_id; })->unique()->all();
        $all_tags_valid = true;
        $one_tag_here = false;
        foreach ($tags as $tag) {
            $users_agree = $actions->filter(function ($action) use ($tag) { return $action->tag_id = $tag; })->count();
            $users_disagree = $users_count - $users_agree;
            // We say that a tag is validated as "absent" or "present" if we have a majority of at least 2 for
            // one of these options.
            $all_tags_valid = $all_tags_valid && (abs($users_agree - $users_disagree) >= 2);
            $one_tag_here = $one_tag_here || $users_agree > $users_disagree;
        }
        return $all_tags_valid && $one_tag_here;
    }

    private function hasSemiConverged($actions, $users_count)
    {
        $tags = $actions->map(function ($action) { return $action->tag_id; })->unique()->all();
        $one_tag_here = false;
        foreach ($tags as $tag) {
            $users_agree = $actions->filter(function ($action) use ($tag) { return $action->tag_id = $tag; })->count();
            $users_disagree = $users_count - $users_agree;
            $one_tag_here = $one_tag_here || $users_agree > $users_disagree;
        }
        return $one_tag_here;
    }
}
