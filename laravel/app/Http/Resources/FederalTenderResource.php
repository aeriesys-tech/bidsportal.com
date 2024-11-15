<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class FederalTenderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        if($this->posted_date) {
            if($request->time_zone) {
                $difference = Carbon::parse($this->posted_date)
                    ->setTimezone($request->time_zone);
            } else {
                $difference = Carbon::parse($this->posted_date)
                    ->setTimezone('Asia/Kolkata');
            }

            $time_ago  = $difference->diffForHumans();
        }

        if ($this->posted_date && $this->expiry_date) {
            $date1 = Carbon::parse($this->posted_date);
            $date2 = Carbon::parse($this->expiry_date);

            if ($date1->lessThan($date2)) {
                $days_difference = round($date1->diffInDays($date2) + 1); 
            } else if ($date2->lessThan($date1)){
                $days_difference = round($date2->diffInDays($date1) + 1); 
            } else  {
                $days_difference = null; 
            }
        } else {
            $days_difference = null;
        }

        $place_of_performance = null;
        if($this->FederalPlaceOfPerformance){
            if($this->FederalPlaceOfPerformance->city_name){
                $place_of_performance = $this->FederalPlaceOfPerformance->city_name;                
            }

            if($this->FederalPlaceOfPerformance->state_name){
                if($place_of_performance){
                    $place_of_performance = $place_of_performance .', '.$this->FederalPlaceOfPerformance->state_name;
                }else{
                    $place_of_performance = $this->FederalPlaceOfPerformance->state_name;
                }
            }

            if($this->FederalPlaceOfPerformance->country_name){
                if($place_of_performance){
                    $place_of_performance = $place_of_performance .', '.$this->FederalPlaceOfPerformance->country_name;
                }else{
                    $place_of_performance = $this->FederalPlaceOfPerformance->country_name;
                }
            }

        } else if($this->FederalOfficeAddress && !$place_of_performance){
            if($this->FederalOfficeAddress->city){
                $place_of_performance = $this->FederalOfficeAddress->city;                
            }

            if($this->FederalOfficeAddress->state){
                if($place_of_performance){
                    $place_of_performance = $place_of_performance .', '.$this->FederalOfficeAddress->state;
                }else{
                    $place_of_performance = $this->FederalOfficeAddress->state;
                }
            }

            if($this->FederalOfficeAddress->country){
                if($place_of_performance){
                    $place_of_performance = $place_of_performance .', '.$this->FederalOfficeAddress->country;
                }else{
                    $place_of_performance = $this->FederalOfficeAddress->country;
                }
            }            
        } else{
            $place_of_performance = null;
        }

        return [
            'federal_tender_id' => $this->federal_tender_id,
            'tender_no' => $this->tender_no,
            'title' => $this->title,
            'description' => $this->description,
            'opening_date' => $this->opening_date,
            'posted_date' => $this->posted_date,
            'expiry_date' => $this->expiry_date,
            'country_id' => $this->country_id,
            'state_id' => $this->state_id,
            'federal_tender_id' => $this->federal_tender_id,
            'federal_notice_id' => $this->federal_notice_id,
            'federal_notice' => $this->FederalNotice,
            'category_id' => $this->category_id,
            'federal_agency_id' => $this->federal_agency_id,
            'federal_agency' => $this->FederalAgency,
            'set_aside_id' => $this->set_aside_id,
            'naics_id' => $this->naics_id,
            'psc_id' => $this->psc_id,
            'tender_url' => $this->tender_url,
            'fees' => $this->fees,
            'type_of_award' => $this->type_of_award,
            'place_of_performance' => $place_of_performance,
            'notice_id' => $this->notice_id,
            'description_link' => $this->description_link,
            'category_name' => $this->category_name,
            'notice_name' => $this->notice_name,
            'agency_name' => $this->agency_name,
            'time_ago'  => $time_ago,
            'days_difference' => $days_difference,
            'federal_attachments' => $this->FederalAttachments,
            'federal_office_address' => $this->FederalOfficeAddress

        ];
    }
}
