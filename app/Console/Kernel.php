<?php

namespace App\Console;

use App\Console\Commands\CacheScores;
use App\Console\Commands\DumpActions;
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
        // Each night
        $schedule->command('command:cache_scores')->dailyAt('02:30');
        $schedule->command('command:dump_actions')->dailyAt('03:00');
        // Manual
        // $schedule->command('command:refresh_priority_responses')->dailyAt('03:30');
        // Each hour
        $schedule->command('command:refresh_priority_questions')->hourly();
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
