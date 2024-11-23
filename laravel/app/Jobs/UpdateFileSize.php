<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\StateTender;
use App\Models\StateAttachment;
use Storage;
use Illuminate\Support\Facades\Log;

class UpdateFileSize implements ShouldQueue
{
    use Queueable;

    protected $state_attachment;

    public function __construct($state_attachment)
    {
        $this->state_attachment = $state_attachment;
     }


    public function handle(): void
    {
        $state_attachment = $this->state_attachment;
        try{
            $state_tender = StateTender::where('state_tender_id', $state_attachment->state_tender_id)->first();
            
            if($state_tender){

                $file_path = "State/attachments/$state_attachment->attachment_date/$state_tender->tender_no/$state_attachment->attachment_name";
                Log::warning("file_path: " . $file_path);
                if (Storage::disk('s3')->exists($file_path)) {
                    $file_size = Storage::disk('s3')->size($file_path);
                    Log::warning("file_size: " . $file_size);
                    StateAttachment::where('state_attachment_id', $state_attachment->state_attachment_id)->update([
                        'attachment_size' => $file_size
                    ]);
                } else {
                    Log::warning("File not found in S3: " . $state_attachment->attachment_name);
                }
            }
        } catch (\Exception $e) {
            Log::error("Error processing attachment ID {$state_attachment->state_attachment_id}: " . $e->getMessage(), [
                'file_name' => $state_attachment->attachment_name,
                'exception' => $e
            ]);
        }
    }
}
