<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule
            ->command('ark:maintain:delegates')
            ->everyFiveMinutes()
            ->withoutOverlapping();

        $schedule
            ->command('ark:poll:avatars')
            ->everyThirtyMinutes()
            ->withoutOverlapping();

        $schedule
            ->command('ark:poll:delegates')
            ->everyMinute()
            ->withoutOverlapping();

        $schedule
            ->command('ark:poll:approval')
            ->everyMinute()
            ->withoutOverlapping();

       $schedule
            ->command('ark:poll:supply')
            ->everyFiveMinutes()
            ->withoutOverlapping();

        $schedule
            ->command('ark:poll:blocks')
            ->everyMinute()
            ->withoutOverlapping();

        $schedule
            ->command('ark:poll:voters-count')
            ->everyFiveMinutes()
            ->withoutOverlapping();

        $schedule
            ->command('ark:poll:voters')
            ->everyFiveMinutes()
            ->withoutOverlapping();

        $schedule
            ->command('ark:cache:stablity')
            ->everyFiveMinutes()
            ->withoutOverlapping();

        $schedule
            ->command('ark:cache:calculator')
            ->everyFiveMinutes()
            ->withoutOverlapping();

        $schedule
            ->command('ark:cache:forging')
            ->everyMinute()
            ->withoutOverlapping();

        $schedule
            ->command('backup:clean')
            ->daily();

        $schedule
            ->command('backup:run')
            ->daily();

        $schedule
            ->command('backup:monitor')
            ->daily();

        $schedule
            ->command('telescope:prune')
            ->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
    }
}
