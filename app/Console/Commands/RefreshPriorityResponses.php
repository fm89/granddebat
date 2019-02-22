<?php

namespace App\Console\Commands;

use App\Models\Response;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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
        $readings = Response::join('actions', 'actions.response_id', 'responses.id')
            ->select('responses.clean_value_group_id', DB::raw('COUNT(DISTINCT (actions.user_id)) AS counts'))
            ->groupBy('responses.clean_value_group_id')
            ->pluck('counts', 'responses.clean_value_group_id');
        // 2. Then untagged responses
        DB::table('responses')->update(['priority' => 1]);
        foreach ($readings as $clean_value_group_id => $user_count) {
            if ($user_count >= 3) {
                // 3. And very last, those with already 3 answers
                DB::table('responses')->where('clean_value_group_id', $clean_value_group_id)->update(['priority' => 0]);
            } else {
                // 1. First read already tagged responses
                DB::table('responses')->where('clean_value_group_id', $clean_value_group_id)->update(['priority' => 2]);
            }
        }
    }
}
