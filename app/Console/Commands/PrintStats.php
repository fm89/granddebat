<?php

namespace App\Console\Commands;

use App\Models\Debate;
use App\Models\Response;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PrintStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:print_stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prints statistics';

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
        $debates = Debate::orderBy('id')->get();
        foreach ($debates as $debate) {
            $questions = $debate->questions()->where('status', 'open')->orderBy('order')->get();
            foreach ($questions as $question) {
                $this->handleQuestion($question);
            }
        }
    }

    private function handleQuestion($question)
    {
        $countAllByGroup = Response::select('clean_value_group_id', DB::raw('COUNT(*) AS counts'))
            ->groupBy('clean_value_group_id')
            ->where('question_id', $question->id)
            ->pluck('counts', 'clean_value_group_id');
        $countWithActionsByGroup = Response::select('clean_value_group_id', DB::raw('COUNT(*) AS counts'))
            ->groupBy('clean_value_group_id')
            ->where('question_id', $question->id)
            ->whereHas('actions')
            ->pluck('counts', 'clean_value_group_id');
        $totalResponses = $question->responses()->count();
        $singleResponses = self::countOnes($countAllByGroup);
        $singleResponsesWithActions = self::countOnes($countWithActionsByGroup);
        if ($singleResponsesWithActions < $singleResponses) {
            # See doc/MATH.md
            $draws = log(1 - $singleResponsesWithActions / $singleResponses) / log(1 - 1 / $singleResponses) * $totalResponses / $singleResponses;
        } else {
            # Infinite number of draws
            $draws = -1;
        }
        $this->info($question->id . ';' . $draws);
    }

    private static function countOnes($array)
    {
        $result = 0;
        foreach ($array as $key => $value) {
            if ($value === 1) {
                $result += 1;
            }
        }
        return $result;
    }
}
