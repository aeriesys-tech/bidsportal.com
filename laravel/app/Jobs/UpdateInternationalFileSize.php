<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\InternationalTender;
use App\Models\InternationalAttachment;
use Storage;
use Illuminate\Support\Facades\Log;

class UpdateInternationalFileSize implements ShouldQueue
{
    use Queueable;

    protected $international_attachment;

    public function __construct($international_attachment)
    {
        $this->international_attachment = $international_attachment;
     }


    public function handle(): void
    {
        $international_attachment = $this->international_attachment;
        try{
            $international_tender = InternationalTender::where('international_tender_id', $international_attachment->international_tender_id)->first();
            
            if($international_tender){

                $file_path = "State/attachments/$international_attachment->attachment_date/$international_tender->tender_no/$international_attachment->attachment_name";
                Log::warning("file_path: " . $file_path);
                if (Storage::disk('s3')->exists($file_path)) {
                    $file_size = Storage::disk('s3')->size($file_path);
                    Log::warning("file_size: " . $file_size);
                    InternationalAttachment::where('international_attachment_id', $international_attachment->international_attachment_id)->update([
                        'attachment_size' => $file_size
                    ]);
                } else {
                    Log::warning("File not found in S3: " . $international_attachment->attachment_name);
                }
            }
        } catch (\Exception $e) {
            Log::error("Error processing attachment ID {$international_attachment->international_attachment_id}: " . $e->getMessage(), [
                'file_name' => $international_attachment->attachment_name,
                'exception' => $e
            ]);
        }
    }
}
