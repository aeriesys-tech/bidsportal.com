<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\FederalTender;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\State;
use App\Models\FederalNotice;
use App\Models\FederalAgency;
use App\Models\SetAside;
use App\Models\Naics;
use App\Models\Psc;
use App\Models\FederalAttachment;
use App\Models\FederalContact;
use App\Models\FederalOfficeAddress;
use App\Models\FederalPlaceOfPerformance;
use App\Models\FederalTenderLink;
use App\Jobs\UpdateFederalAttachment;
use App\Jobs\UpdateFederalDescriptionJob;


class TenderProcess implements ShouldQueue
{
    use Queueable;

    public $response; 
    public $api_key; 

    /**
     * Create a new job instance.
     */
    public function __construct($response, $api_key)
    {
        $this->response = $response;
        $this->api_key = $api_key;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach($this->response as $opportunity)
        {
            $tender_no = (isset($opportunity['solicitationNumber']) && $opportunity['solicitationNumber']!=null)?$opportunity['solicitationNumber']:'';
            $tender_number = str_replace($tender_no, '-', '');
            
            $title= (isset($opportunity['title']) && $opportunity['title']!==null)?$opportunity['title']:'';

            $opening_date= (isset($opportunity['postedDate']) && $opportunity['postedDate']!=null)?$opportunity['postedDate']:'';
          
            try {
                    $expiry_date = Carbon::parse($opportunity['archiveDate'])->format('Y-m-d');
                    if ($expiry_date->year > 2026) {
                        $expiry_date = Carbon::create(2026, 12, 31)->format('Y-m-d');
                    }
                } catch (\Exception $e) {
                    $expiry_date = Carbon::now()->addDays(15)->format('Y-m-d');
                }
            $country_id = 10;
            
            //State
            $state_code = isset($opportunity['placeOfPerformance']) && isset($opportunity['placeOfPerformance']['state']) && isset($opportunity['placeOfPerformance']['state']['code']) ? $opportunity['placeOfPerformance']['state']['code'] : null;

            if($state_code){
                $state = State::where('state_code', $state_code)->first();
                if($state){
                    $state_id = $state->state_id;
                }else{
                    $state_id = null;
                }
            }else{
                $state_id = null;
            }

            //Federal Notice
            $notice_type = isset($opportunity['type']) && !empty($opportunity['type']) ? $opportunity['type'] : null;
            if($notice_type){
                $notice = FederalNotice::orderBy('sort', 'desc')->first();
                $federal_notice = FederalNotice::firstOrCreate([
                    'notice_name'=> $notice_type
                ],           
                [
                    'sort'=> $notice->sort+1,
                    'backround_color'=>'red'
                ]);
                if($federal_notice){
                    $federal_notice_id = $federal_notice->federal_notice_id;
                }else{
                    $federal_notice_id = null;  
                }
            }else{
                $federal_notice_id = null;
            }

            //Federal Agency
            if (isset($opportunity['fullParentPathCode']) && !empty($opportunity['fullParentPathCode'])) {
                $agency_code = explode('.', $opportunity['fullParentPathCode']);
                $tdr_agency_code = isset($agency_code[1]) ? $agency_code[1] : null; 
            } else {
                $tdr_agency_code = null; 
            }

            if (isset($opportunity['fullParentPathName']) && !empty($opportunity['fullParentPathName'])) {
                $agency_name = explode('.', $opportunity['fullParentPathName']);
                $tdr_agency_name = isset($agency_name[1]) ? $agency_name[1] : null; 
            } else {
                $tdr_agency_name = null; 
            }

            if($tdr_agency_name){
                $federal_agency = FederalAgency::firstOrCreate(
                    [
                        'agency_name' => $tdr_agency_name
                    ],
                    [
                        'agency_code' => $tdr_agency_code
                    ]
                );

                if($federal_agency){
                    $federal_agency_id = $federal_agency->federal_agency_id;
                }else{
                    $federal_agency_id = null;
                }
            }else{
                $federal_agency_id = null;
            }

            //Set Aside
            if(isset($opportunity['typeOfSetAsideDescription']) && !empty($opportunity['typeOfSetAsideDescription'])){
                $set_aside_sort = SetAside::orderBy('sort', 'desc')->first();
                $set_aside = SetAside::firstOrCreate(
                    [ 
                        'set_aside_name' => $opportunity['typeOfSetAsideDescription']
                    ],

                    [
                        'sort'=> $set_aside_sort->sort+1
                    ]
                );

                if($set_aside){
                    $set_aside_id = $set_aside->set_aside_id;
                }else{
                    $set_aside_id = null;
                }
            }else{
                $set_aside_id = null;
            }

            //Naics
            if (isset($opportunity['naicsCode']) && !empty($opportunity['naicsCode'])) {
                $naics = Naics::where('naics_code', $opportunity['naicsCode'])->first();
                if($naics){
                    $naics_id = $naics->naics_id;
                }else{
                    $naics_id = null;
                }
            }else{
                $naics_id = null; 
            }

            //Pscs
            if (isset($opportunity['classificationCode']) && !empty($opportunity['classificationCode'])) {
                $psc = Psc::where('psc_code', $opportunity['classificationCode'])->first();
                if($psc){
                    $psc_id = $psc->psc_id;
                }else{
                    $psc_id = null;
                }
            }else{
                $psc_id = null; 
            }

            //tender link
            if (isset($opportunity['uiLink']) && !empty($opportunity['uiLink'])) {
                $tender_url = $opportunity['uiLink'];
            }else{
                $tender_url = null;
            }

            //Description link
            if (isset($opportunity['description']) && !empty($opportunity['description'])) {
                $description_link = $opportunity['description'];
            }else{
                $description_link = null;
            }

            //Notice Id
            if (isset($opportunity['noticeId']) && !empty($opportunity['noticeId'])) {
                $notice_id = $opportunity['noticeId'];
            }else{
                $notice_id = null;
            }

            try {
                $federal_tender = FederalTender::where('tender_no', $tender_no)->first();
                if($federal_tender){
                    $federal_tender->update([
                    'title' => $title,
                    'opening_date' => $opening_date,
                    'posted_date' => Carbon::now(),
                    'expiry_date' => $expiry_date,
                    'country_id' => $country_id,
                    'state_id' => $state_id,
                    'federal_notice_id' => $federal_notice_id,
                    'federal_agency_id' => $federal_agency_id,
                    'set_aside_id' => $set_aside_id,
                    'naics_id' => $naics_id,
                    'psc_id' => $psc_id,
                    'tender_url' => $tender_url,
                    'description_link' => $description_link,
                    'notice_id' => $notice_id,
                    'tender_number' => $tender_number
                ]);
                }else{
                    $federal_tender = FederalTender::create([
                        'tender_no' => $tender_no,
                        'tender_number' => $tender_number,
                        'title' => $title,
                        'opening_date' => $opening_date,
                        'posted_date' => Carbon::now(),
                        'expiry_date' => $expiry_date,
                        'country_id' => $country_id,
                        'state_id' => $state_id,
                        'federal_notice_id' => $federal_notice_id,
                        'federal_agency_id' => $federal_agency_id,
                        'set_aside_id' => $set_aside_id,
                        'naics_id' => $naics_id,
                        'psc_id' => $psc_id,
                        'tender_url' => $tender_url,
                        'description_link' => $description_link,
                        'notice_id' => $notice_id
                    ]);
                    // UpdateFederalDescriptionJob::dispatch($federal_tender->federal_tender_id);
                }
                if (isset($opportunity['resourceLinks'])) {
                    foreach ($opportunity['resourceLinks'] as $attachment) {
                        $attachment_exists = FederalAttachment::where('federal_tender_id', $federal_tender->federal_tender_id)->where('attachment_name', $federal_tender->tender_no)->where('attachment_url', $attachment)->first();
                        if(!$attachment_exists){   
                            $federal_attachment = FederalAttachment::create([
                                'federal_tender_id' => $federal_tender->federal_tender_id,
                                'attachment_name' => $federal_tender->tender_no,
                                'attachment_url' => $attachment
                            ]);
                            UpdateFederalAttachment::dispatch($federal_attachment);
                        }else{
                            UpdateFederalAttachment::dispatch($attachment_exists);
                        }
                    }
                }

                if (isset($opportunity['pointOfContact'])) {
                    foreach ($opportunity['pointOfContact'] as $key => $contact) {
                        FederalContact::updateOrCreate([
                            'federal_tender_id' => $federal_tender->federal_tender_id,
                            'type' => $key,
                            'email' => $contact['email'],
                            'phone' => $contact['phone'],
                            'title' => $contact['title'],
                            'full_name' => $contact['fullName']
                        ]);
                    }
                }

                if (isset($opportunity['officeAddress']) && !empty($opportunity['officeAddress'])) {
                    FederalOfficeAddress::updateOrCreate([
                        'federal_tender_id' => $federal_tender->federal_tender_id,
                        'city' => $opportunity['officeAddress']['city']??null,
                        'state' => $opportunity['officeAddress']['state']??null,
                    ],
                    [
                        'country' => $opportunity['officeAddress']['countryCode']??null,
                        'zip_code' => $opportunity['officeAddress']['zipcode']??null
                    ]);
                }

                if (isset($opportunity['placeOfPerformance']) && !empty($opportunity['placeOfPerformance'])) {
                    FederalPlaceOfPerformance::updateOrCreate([
                        'federal_tender_id' => $federal_tender->federal_tender_id,
                        'city_code' => $opportunity['placeOfPerformance']['city']['code']??null,
                        'city_name' => $opportunity['placeOfPerformance']['city']['name']??null,
                        'state_code' => $opportunity['placeOfPerformance']['state']['code']??null,
                        'state_name' => $opportunity['placeOfPerformance']['state']['name']??null,
                        'country_code' => $opportunity['placeOfPerformance']['country']['code']??null,
                        'country_name' => $opportunity['placeOfPerformance']['country']['code']??null,
                        'zip' => $opportunity['placeOfPerformance']['zip']??null,
                    ]);
                }
                $tender_link = null;
                if (isset($opportunity['links'])) {
                    foreach ($opportunity['links'] as $link) {   
                        $tender_link = $link['href']??null; 
                        FederalTenderLink::create([
                            'federal_tender_id' => $federal_tender->federal_tender_id,
                            'rel' => $link['rel']??null,
                            'href' => $link['href']??null
                        ]);
                    }
                }
            } catch (\Exception $e) {
                FederalTenderLog::create([
                    'notice_id' => $notice_id,
                    'tender_no' => $tender_no,
                    'error' => e->getMessage(),
                    'tender_link' => $tender_link,
                    'posted_date' => Carbon::now()
                ]);
            }
        }
    }
}
