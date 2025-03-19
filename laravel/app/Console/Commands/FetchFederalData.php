<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ApiKey;
use Illuminate\Support\Facades\Http;
use App\Jobs\TenderProcess;
use App\Models\FederalTender;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\FederalTenderController;

class FetchFederalData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-federal-data';

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
        $api_key_res = ApiKey::first();
        if($api_key_res){
            $api_key = $api_key_res->api_key;
        }else{
            $api_key="8UPYOoBOM5C3ZSFpaxt1sIvZ3byn2Jfb91XoGyMT";
        }
        $posted_from= date('m/d/Y', strtotime("-1 days"));
        $posted_to = $posted_from;

        $url = "https://api.sam.gov/prod/opportunities/v2/search?limit=1&api_key={$api_key}&postedFrom={$posted_from}&postedTo={$posted_to}";
        $this->info($url);

        $response = Http::get($url);

        if ($response->successful()) {
            $data = $response->json();
            $total_records = $data['totalRecords'];
            $limit=1000;
            $last_offset=$total_records-($total_records%$limit); 
            $offset_array=[];
            for($offset=0; $offset<=$last_offset; $offset=$offset+$limit)
            {
                array_push($offset_array, $offset);         
            }
            $this->info('total_records', $total_records);

            foreach ($offset_array as $offset) 
            {
                $api_link_offset ='https://api.sam.gov/prod/opportunities/v2/search?limit='.$limit.'&offset='.$offset.'&api_key='.$api_key.'&postedFrom='.$posted_from.'&postedTo='.$posted_to;
                
                $response_data = Http::get($api_link_offset);
                if ($response_data->successful()) {
                    $federal_response = $response_data->json();
                    $chunks = array_chunk($federal_response['opportunitiesData'], 1);
                    foreach($chunks as $key => $chunk)
                    {
                         TenderProcess::dispatch($chunk, $api_key, $api_link_offset);
                    }
                }
            }
            Queue::after(function ($event) {
                $federal_tender = new FederalTenderController;
                $federal_tender->updateDescriptions();
                $this->info('Descriptions updated after queue processing.');
            });
            $this->info('Opportunities fetched and queued for processing.');
        } else {
            $this->error('Failed to fetch data from API');
        }
    }
}
