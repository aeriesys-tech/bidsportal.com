<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use GuzzleHttp\Client;
use App\Models\ApiKey;
use App\Models\FederalTender;

class UpdateFederalDescriptionJob implements ShouldQueue
{
    use Queueable;
    public $federal_tender_id;

    /**
     * Create a new job instance.
     */
    public function __construct($federal_tender_id)
    {
        $this->federal_tender_id = $federal_tender_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $client = new Client();
        $api_key = ApiKey::first()?->api_key ?? "8UPYOoBOM5C3ZSFpaxt1sIvZ3byn2Jfb91XoGyMT";
        $federal_tender = FederalTender::where('federal_tender_id', $this->federal_tender_id)->first();
        if($federal_tender){
            $url = $federal_tender->description_link . "&api_key=" . $api_key;        
            $response = $client->get($url);
            $responseBody = json_decode($response->getBody(), true);
            $description = $responseBody['description'] ?? null;
            $federal_tender->update(['description' => $description]);
        }
    }
}
