<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\FederalTenderController;


class UpdateFederalDescription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-federal-description';

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
        $federal_tender = new FederalTenderController;  
        $federal_tender->updateDescriptions();
    }
}
