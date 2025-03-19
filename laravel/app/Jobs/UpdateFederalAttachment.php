<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use GuzzleHttp\Client;
use DateTime;
use DateTimeZone;
use Storage;
use App\Models\FederalAttachment;

class UpdateFederalAttachment implements ShouldQueue
{
    use Queueable;

    public $federal_attachment;

    /**
     * Create a new job instance.
     */
    public function __construct($federal_attachment)
    {
        $this->federal_attachment = $federal_attachment;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $client = new Client();
        $federal_attachment = $this->federal_attachment;
        
        $response = $client->get($federal_attachment->attachment_url); 
        $header=$response->getheaders();
        if(isset($header['Content-Length']) && is_array($header['Content-Length'])){
            $attachment_size = $header['Content-Length'][0];
        }

        if(isset($header['Last-Modified']) && is_array($header['Last-Modified'])){
            $dt = new DateTime($header['Last-Modified'][0], new DateTimeZone('UTC'));
            $attachment_date = $dt->format('Y-m-d');
        }

        if(isset($header['Content-Disposition']) && is_array($header['Content-Disposition'])){
            $content_disposition=explode('=',$header['Content-Disposition'][0]);
            $attachment_name = $content_disposition[1];
         }

        $file_path = 'Federal/'.$attachment_name; 
        Storage::disk('s3')->put($file_path, file_get_contents($federal_attachment->attachment_url));
        if (Storage::disk('s3')->exists($file_path)) {
            $attachment_s3_url = Storage::disk('s3')->url($file_path);
        }else{
            $attachment_s3_url = null;
        }

        FederalAttachment::where('federal_attachment_id', $federal_attachment->federal_attachment_id)->update([
            'attachment_name' => $attachment_name,
            'attachment_size' => $attachment_size,
            'attachment_date' => $attachment_date,
            'attachment_s3_url' => $attachment_s3_url
        ]);
        
    }
}
