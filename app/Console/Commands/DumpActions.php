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
        $fileName = 'storage/app/public/actions' . date("Ymd");
        $this->generateCsvDump($fileName);
        $this->generateArchive($fileName);
    }

    private function generateCsvDump($fileName)
    {
        $handle = fopen($fileName . '.csv', 'w');
        fputcsv($handle, ["Debat", "Contribution", "Question", "Categorie", "Annoteur"]);
        DB::table('actions')
            ->join('tags', 'tags.id', 'actions.tag_id')
            ->join('responses', 'responses.id', 'actions.response_id')
            ->join('questions', 'questions.id', 'responses.question_id')
            ->select('questions.debate_id',
                DB::raw('CONCAT(questions.debate_id, \'-\', actions.response_id % 1000000) AS "proposal_id"'),
                DB::raw('actions.response_id / 1000000 AS "question_id"'),
                'tags.name',
                'actions.user_id')
            ->where('questions.status', 'open')
            ->orderBy('questions.debate_id')
            ->orderBy('actions.response_id')
            ->orderBy('tags.name')
            ->chunk(10000, function ($actions) use ($handle) {
                foreach ($actions as $fields) {
                    fputcsv($handle,
                        [
                            $fields->debate_id,
                            $fields->proposal_id,
                            $fields->question_id,
                            $fields->name,
                            $fields->user_id
                        ]);
                }
            });
        fclose($handle);
    }

    private function generateArchive($fileName)
    {
        $zip = new \ZipArchive();
        $zip->open($fileName . '.zip', \ZipArchive::CREATE);
        $zip->addFile('public/data/LICENSE.txt', 'LICENSE.txt');
        $zip->addFile('public/data/README.txt', 'README.txt');
        $zip->addFile($fileName . '.csv', 'actions.csv');
        $zip->close();
    }
}
