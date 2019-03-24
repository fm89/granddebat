<?php

namespace App\Console\Commands;

use App\Models\Debate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DumpTexts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:dump_texts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Stores a full dump of texts for later "open data" retrieval';

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
        $fileName = 'storage/app/public/texts';
        $this->generateCsvDump($fileName);
        $this->generateArchive($fileName);
    }

    private function generateCsvDump($fileName)
    {
        $handle = fopen($fileName . '.csv', 'w');
        fputcsv($handle, ["Debat", "Question", "Annotateur", "Texte"]);
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
        DB::table('texts')
            ->where('question_id', $question->id)
            ->orderBy('user_id')
            ->chunk(10000, function ($actions) use ($handle, $debate_id, $question_id) {
                foreach ($actions as $fields) {
                    fputcsv($handle,
                        [
                            $debate_id,
                            $question_id,
                            $fields->user_id,
                            $fields->content,
                        ]);
                }
            });
    }

    private function generateArchive($fileName)
    {
        $zip = new \ZipArchive();
        $zip->open($fileName . '.zip', \ZipArchive::CREATE);
        $zip->addFile('public/resources/LICENSE.txt', 'LICENSE.txt');
        $zip->addFile($fileName . '.csv', 'texts.csv');
        $zip->close();
    }
}
