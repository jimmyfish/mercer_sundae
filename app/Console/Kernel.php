<?php

namespace App\Console;

use App\Console\Commands\Core\AddWatchListCommand;
use App\Console\Commands\Core\ProcessPairsCommand;
use App\Console\Commands\Core\ProcessTickerDataCommand;
use App\Console\Commands\Core\RemoveWatchListCommand;
use App\Console\Commands\KeyGenerateCommand;
use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        KeyGenerateCommand::class,
        ProcessPairsCommand::class,
        AddWatchListCommand::class,
        ProcessTickerDataCommand::class,
        RemoveWatchListCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //
    }
}
