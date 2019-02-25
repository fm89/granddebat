<?php

namespace App\Console\Commands;

use App\Logic\Priority;
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
        $questions = Question::all();
        foreach ($questions as $question) {
            $this->info("\n\nHandling question " . $question->id);
            $this->handleQuestion($question);
        }
    }

    private function handleQuestion(Question $question)
    {
        $responses = Response::where('question_id', $question->id)->whereHas('actions')->get();
        $this->info('Preparing to process ' . count($responses) . ' responses');
        $bar = $this->output->createProgressBar(count($responses));
        $bar->start();
        foreach ($responses as $response) {
            $priority = Priority::getFor($response);
            if ($priority != $response->$priority) {
                // Don't issue an UPDATE query if not necessary
                $response->priority = $priority;
                $response->save();
            }
            $bar->advance();
        }
        $bar->finish();
    }
}
