<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FederalAttachment;
use App\Models\FederalTender;
use GuzzleHttp\Client;
use DateTime;
use DateTimeZone;
use Storage;

class FederalAttachmentController extends Controller
{
    public function updateAttachments(){
    	$federal_attachments = FederalAttachment::whereHas('FederalTender', function($que){
    		$que->where('is_latest', 1);
    	})->get();
    	$client = new Client();  
    	foreach ($federal_attachments as $federal_attachment) {

    		$attachment_name = null;
    		$attachment_date = null;
    		$attachment_size = null;

            if(isset($federal_attachment['attachment_url'])){

                try {
            		$response = $client->get($federal_attachment['attachment_url']); 
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

                	$file_path = 'Federal/testing'.$attachment_name; 
                    Storage::disk('s3')->put($file_path, file_get_contents($federal_attachment['attachment_url']));
                    if (Storage::disk('s3')->exists($file_path)) {
                        $attachment_s3_url = Storage::disk('s3')->url($file_path);
                    }else{
                        $attachment_s3_url = null;
                    }

                    FederalAttachment::where('federal_attachment_id', $federal_attachment['federal_attachment_id'])->update([
                        'attachment_name' => $attachment_name,
                        'attachment_size' => $attachment_size,
                        'attachment_date' => $attachment_date,
                        'attachment_s3_url' => $attachment_s3_url
                    ]);
                }catch (RequestException $e) {
                    Log::error('Failed to fetch file: ' . $e->getMessage() . ' for URL: ' . $url);
                    continue;
                }
            }
    		
    	}

    	$teder_ids_to_update = FederalAttachment::select('federal_tender_id')->whereHas('FederalTender', function ($que) {
            	$que->where('is_latest', 1);
        	})->groupBy('federal_tender_id')->havingRaw('SUM(CASE WHEN attachment_size IS NULL AND attachment_date IS NULL THEN 1 ELSE 0 END) = 0')->pluck('federal_tender_id');

	    FederalTender::whereIn('federal_tender_id', $teder_ids_to_update)->update(['is_latest' => 0]);
    }
}
