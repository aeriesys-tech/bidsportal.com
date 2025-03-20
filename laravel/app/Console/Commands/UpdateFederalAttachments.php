<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\FederalAttachmentController;

class UpdateFederalAttachments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-federal-attachments';

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
        $federal_attachments = new FederalAttachmentController;  
        $federal_attachments->updateAttachments();
        $this->info('Update federal attachments');
    }
}
