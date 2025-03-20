<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FederalFilterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'federal_filter_id' => $this->federal_filter_id,
            'federal_filter_name' => $this->federal_filter_name,
            'user_id' => $this->user_id,
            'posted_date' => $this->posted_date,
            'active' => $this->active?true:false,
            'expired' => $this->expired?true:false,
            'posted_from_date' => $this->posted_from_date,
            'posted_to_date' => $this->posted_to_date,
            'response_date' => $this->response_date,
            'response_from_date' => $this->response_from_date,
            'response_to_date' => $this->response_to_date,

            //keywords
            'keywords' => $this->FederalFilterKeywords ? collect($this->FederalFilterKeywords->toArray())->map(function($keyword) {
                    return $keyword['keyword'];
                })->toArray() : [],

            //federal_notices
            'federal_notices' => $this->FederalFilterNotices ? collect($this->FederalFilterNotices->toArray())->map(function($federal_notice) {
                    return $federal_notice['federal_notice_id'];
                })->toArray() : [],

            //federal_naics
            'naics' => $this->FederalFilterNaics ? collect($this->FederalFilterNaics->toArray())->map(function($federal_naics) {
                    return $federal_naics['naics_id'];
                })->toArray() : [],

            //federal_psc
            'pscs' => $this->FederalFilterPscs ? collect($this->FederalFilterPscs->toArray())->map(function($federal_psc) {
                    return $federal_psc['psc_id'];
                })->toArray() : [],

            //federal_states
            'states' => $this->FederalFilterStates ? collect($this->FederalFilterStates->toArray())->map(function($federal_state) {
                    return $federal_state['state_id'];
                })->toArray() : [],

            //federal_set_asides
            'set_asides' => $this->FederalFilterSetAsides ? collect($this->FederalFilterSetAsides->toArray())->map(function($federal_set_aside) {
                    return $federal_set_aside['set_aside_id'];
                })->toArray() : [],

            //federal_agencies
            'federal_agencies' => $this->FederalFilterAgencies ? collect($this->FederalFilterAgencies->toArray())->map(function($federal_agency) {
                    return $federal_agency['federal_agency_id'];
                })->toArray() : []  
        ];
    }

}
