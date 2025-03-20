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
        // $schedule->command('app:update-federal-attachments')->dailyAt('10:49');
        // $schedule->command('app:update-federal-description')->dailyAt('10:48');
        $schedule->command('app:update-federal-description')->hourlyAt(30)->between('06:30', '23:59');
    }
}
