<?php

namespace App\Console\Commands;

use App\Logic\Weights;
use App\Models\Debate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DumpResults extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:dump_results';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Stores a full dump of results for later "open data" retrieval';

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
        $fileName = 'storage/app/public/results';
        $this->generateCsvDump($fileName);
        $this->generateArchive($fileName);
    }

    private function generateCsvDump($fileName)
    {
        $handle = fopen($fileName . '.csv', 'w');
        fputcsv($handle, ["Debat", "Contribution", "Question", "Categorie", "Poids"]);
        $debates = Debate::orderBy('id')->get();
        foreach ($debates as $debate) {
            $questions = $debate->questions()->where('status', 'open')->orderBy('order')->get();
            foreach ($questions as $question) {
                $this->info('Processing question #' . $question->id);
                $this->dumpQuestion($question, $handle);
            }
        }
        fclose($handle);
    }

    private function dumpQuestion($question, $handle)
    {
        $debate_id = $question->debate->id;
        $question_id = $question->id;
        DB::table('results')
            ->join('tags', 'tags.id', 'results.tag_id')
            ->join('responses', 'responses.id', 'results.response_id')
            ->join('questions', 'questions.id', 'responses.question_id')
            ->select(
                'results.weight',
                DB::raw('CONCAT(questions.debate_id, \'-\', responses.id % 1000000) AS "proposal_id"'),
                'tags.name')
            ->where('responses.question_id', $question->id)
            ->orderBy('responses.id')
            ->orderBy('tags.name')
            ->chunk(10000, function ($actions) use ($handle, $debate_id, $question_id) {
                foreach ($actions as $fields) {
                    fputcsv($handle,
                        [
                            $debate_id,
                            $fields->proposal_id,
                            $question_id,
                            $fields->name,
                            $fields->weight,
                        ]);
                }
            });
    }

    private function generateArchive($fileName)
    {
        $zip = new \ZipArchive();
        $zip->open($fileName . '.zip', \ZipArchive::CREATE);
        $zip->addFile('public/resources/LICENSE.txt', 'LICENSE.txt');
        $zip->addFile('public/resources/README.txt', 'README.txt');
        $zip->addFile($fileName . '.csv', 'results.csv');
        $zip->close();
    }
}
