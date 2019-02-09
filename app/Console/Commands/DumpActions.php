<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DumpActions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:dump_actions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Stores a full dump of actions for later "open data" retrieval';

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
        $handle = fopen('storage/app/public/actions' . date("Ymd") . '.csv', 'w');
        fputcsv($handle, ["Debat", "Contribution", "Question", "Categorie", "Annoteur"], $delimiter = ";");
        DB::table('actions')
            ->join('tags', 'tags.id', 'actions.tag_id')
            ->join('responses', 'responses.id', 'actions.response_id')
            ->join('questions', 'questions.id', 'responses.question_id')
            ->select('questions.debate_id',
                DB::raw('actions.response_id % 1000000 AS "proposal_id"'),
                DB::raw('actions.response_id / 1000000 AS "question_id"'),
                'tags.name',
                'actions.user_id')
            ->orderBy('questions.debate_id')
            ->orderBy('actions.response_id')
            ->orderBy('tags.name')
            ->chunk(1000, function ($actions) use ($handle) {
                foreach ($actions as $fields) {
                    fputcsv($handle,
                        [$fields->debate_id, $fields->proposal_id, $fields->question_id, $fields->name, $fields->user_id],
                        $delimiter = ";");
                }
            });
        fclose($handle);
    }
}
