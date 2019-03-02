<?php

namespace App\Console\Commands;

use App\Logic\Weights;
use App\Models\Debate;
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
        $fileName = 'storage/app/public/actions';
        $this->generateCsvDump($fileName);
        $this->generateArchive($fileName);
    }

    private function generateCsvDump($fileName)
    {
        $handle = fopen($fileName . '.csv', 'w');
        fputcsv($handle, ["Debat", "Contribution", "Question", "Categorie", "Annotateur", "Poids"]);
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
        $n1 = Weights::getN1ByAuthorId($question);
        $p2 = Weights::getP2ByGroupId($question);
        $debate_id = $question->debate->id;
        $question_id = $question->id;
        DB::table('actions')
            ->join('tags', 'tags.id', 'actions.tag_id')
            ->join('responses', 'responses.id', 'actions.response_id')
            ->join('proposals', 'proposals.id', 'responses.proposal_id')
            ->join('questions', 'questions.id', 'responses.question_id')
            ->select(
                'proposals.author_id',
                'responses.clean_value_group_id',
                DB::raw('CONCAT(questions.debate_id, \'-\', actions.response_id % 1000000) AS "proposal_id"'),
                'tags.name',
                'actions.user_id')
            ->where('responses.question_id', $question->id)
            ->orderBy('actions.response_id')
            ->orderBy('tags.name')
            ->chunk(10000, function ($actions) use ($handle, $debate_id, $question_id, $n1, $p2) {
                foreach ($actions as $fields) {
                    fputcsv($handle,
                        [
                            $debate_id,
                            $fields->proposal_id,
                            $question_id,
                            $fields->name,
                            $fields->user_id,
                            $p2[$fields->clean_value_group_id] / $n1[$fields->author_id],
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
        $zip->addFile($fileName . '.csv', 'actions.csv');
        $zip->close();
    }
}
