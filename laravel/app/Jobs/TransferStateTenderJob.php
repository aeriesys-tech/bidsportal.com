<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use App\Models\StateAgency;
use App\Models\Psc;
use App\Models\TenderType;
use App\Models\StateNotice;
use App\Models\Category;
use App\Models\Naics;
use App\Models\SetAside;
use App\Models\State;
use Carbon\Carbon;

class TransferStateTenderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $jobData;
  
    public function __construct(array $jobData)
    {
        $this->jobData = $jobData;
    }

    public function handle()
    {
        foreach ($this->jobData as $data) 
        {
            //Agency ID
            if($data['tdr_agency'])
            {
                $federalAgency = StateAgency::firstOrCreate(
                    ['state_agency_name' => $data['tdr_agency']],
                    ['created_at' => now(), 'updated_at' => now()]
                );
            }
            $agency_id = $federalAgency->state_agency_id ?? null;

            //PSC ID
            $psc = Psc::where('psc_code', $data['tdr_psc'])->first();
            $psc_id = $psc->psc_id ?? null;
            
            //Tender Type
            if($data['tdr_type'])
            {
                $tenderType = TenderType::firstOrCreate(
                    ['tender_type_name' => $data['tdr_type']],
                    ['created_at' => now(), 'updated_at' => now()]
                );
            }
           
            $tenderType_id = $tenderType->tender_type_id ?? Null;

            $FederalNotice = StateNotice::where('state_notice_id', $data['tdr_notice'])->first();
            $federal_notice_id = $FederalNotice->state_notice_id ?? null;

            //Category
            $category = Category::where('category_id', $data['tdr_country_id'])->first();
            $category_id = $category->category_id ?? null;

            //Naics 
            $naic = Naics::where('naics_id', $data['tdr_naics'])->first();
            $naics_id = $naic->naics_id ?? null;

            //SetAside
            $setAside = SetAside::where('set_aside_id', $data['tdr_set_aside_status'])->first();
            $asside_id = $setAside->set_aside_id ?? null;

            //State
            $state = State::where('state_id', $data['tdr_state_id'])->first();
            $state_id = $state->state_id ?? null;

            //Expire Date
            $expiryDate = Carbon::parse($data['tdr_expiry_date'] ?? null);
            if ($expiryDate && $expiryDate->year > 2026) {
                $expiryDate = Carbon::create(2026, 12, 31)->format('Y-m-d');
            } elseif ($expiryDate) {
                $expiryDate = $expiryDate->format('Y-m-d');
            } else {
                $expiryDate = null;
            }

            $existingTender = DB::connection('mysql')->table('state_tenders')->where('tender_no', $data['tdr_no'])->first();
            if(!$existingTender)
            {
                DB::connection('mysql')->table('state_tenders')->insert([
                    'tender_no' => $data['tdr_no'],
                    'title' => $data['tdr_title'],
                    'description' => $data['tdr_desc'],
                    'opening_date' => ($data['tdr_opening_date'] === '0000-00-00' || empty($data['tdr_opening_date'])) ? '2024-11-14' : $data['tdr_opening_date'],
                    'posted_date' => empty($data['tdr_posted_date']) ? null : $data['tdr_posted_date'],
                    'expiry_date' => $expiryDate,
                    'country_id' => $data['tdr_country_id'],
                    'state_id' => $state_id,
                    'tender_type_id' => $tenderType_id,
                    'state_notice_id' => $federal_notice_id,
                    'category_id' => $category_id,
                    'state_agency_id' => $agency_id,
                    'set_aside_id' => $asside_id ,
                    'naics_id' => $naics_id,
                    'psc_id' => $psc_id,
                    'tender_url' => $data['tdr_posting_link'],
                    'fees' => $data['tdr_doc_fees'],
                    'type_of_award' => $data['tdr_type_of_award'],
                    'place_of_performance' => $data['tdr_place_of_performance'],
                    'notice_id' => $data['noticeId'] ?? Null,
                    'description_link' => $data['description_link']
                ]);
            }
        }
    }
}
