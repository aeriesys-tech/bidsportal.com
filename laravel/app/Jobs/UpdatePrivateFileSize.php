<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\PrivateTender;
use App\Models\PrivateAttachment;
use Storage;
use Illuminate\Support\Facades\Log;

class UpdatePrivateFileSize implements ShouldQueue
{
    use Queueable;

    protected $private_attachment;

    public function __construct($private_attachment)
    {
        $this->private_attachment = $private_attachment;
     }


    public function handle(): void
    {
        $private_attachment = $this->private_attachment;
        try{
            $private_tender = PrivateTender::where('private_tender_id', $private_attachment->private_tender_id)->first();
            
            if($private_tender){

                $file_path = "State/attachments/$private_attachment->attachment_date/$private_tender->tender_no/$private_attachment->attachment_name";
                Log::warning("file_path: " . $file_path);
                if (Storage::disk('s3')->exists($file_path)) {
                    $file_size = Storage::disk('s3')->size($file_path);
                    Log::warning("file_size: " . $file_size);
                    PrivateAttachment::where('private_attachment_id', $private_attachment->private_attachment_id)->update([
                        'attachment_size' => $file_size
                    ]);
                } else {
                    Log::warning("File not found in S3: " . $private_attachment->attachment_name);
                }
            }
        } catch (\Exception $e) {
            Log::error("Error processing attachment ID {$private_attachment->private_attachment_id}: " . $e->getMessage(), [
                'file_name' => $private_attachment->attachment_name,
                'exception' => $e
            ]);
        }
    }
}
