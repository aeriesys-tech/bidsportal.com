<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\AlertController;

class sendAlertMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-alert-mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $alert_controller = new AlertController;  
        $alert_controller->sendStateAlertMails();
    }
}
