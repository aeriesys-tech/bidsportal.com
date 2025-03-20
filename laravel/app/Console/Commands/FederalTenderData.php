<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\DatabaseController;

class FederalTenderData extends Command
{
    protected $signature = 'app:transferFederalTenders';

    protected $description = 'Command description';

    public function handle()
    {
        $federal_tender = new DatabaseController;  
        $federal_tender->transferFederalTenders();
    }
}
