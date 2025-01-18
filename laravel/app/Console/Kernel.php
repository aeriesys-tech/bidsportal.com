<?php

namespace App\Console;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('app:fetch-federal-data')->dailyAt('08:00');
        $schedule->command('app:update-federal-attachments')->dailyAt('09:00');
        $schedule->command('app:update-federal-description')->dailyAt('09:00');
    }
   
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}