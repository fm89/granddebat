<?php

namespace App\Console;

use App\Console\Commands\CacheScores;
use App\Console\Commands\DumpActions;
use App\Console\Commands\DumpResults;
use App\Console\Commands\DumpTexts;
use App\Console\Commands\RefreshPriorityQuestions;
use App\Console\Commands\RefreshPriorityResponses;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        CacheScores::class,
        DumpActions::class,
        DumpResults::class,
        DumpTexts::class,
        RefreshPriorityResponses::class,
        RefreshPriorityQuestions::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // All machines create and store locally their own dump
        $schedule->command('command:dump_actions')->dailyAt('03:05');
        $schedule->command('command:dump_results')->dailyAt('03:15');
        $schedule->command('command:dump_texts')->dailyAt('03:25');
        // Only the master virtual machine runs database update tasks.
        // (There is no need for the other virtual machines to run the same tasks, and it could be risky.)
        if (config('app.is_master_server')) {
            $schedule->command('command:compute_results')->dailyAt('02:05');
            $schedule->command('command:cache_scores')->dailyAt('02:35');
            $schedule->command('command:refresh_priority_questions')->hourly();
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
