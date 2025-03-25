<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;


class ScheduleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(Schedule $schedule): void
    {
        $schedule->command('app:fetch-federal-data')->dailyAt('05:30');
        $schedule->command('app:update-federal-description')->dailyAt('06:30');
        $schedule->command('app:send-alert-mail')->dailyAt('13:30');
    }
}
