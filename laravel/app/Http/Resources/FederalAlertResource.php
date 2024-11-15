<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FederalAlertResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'federal_alert_id' => $this->federal_alert_id,
            'federal_alert_name' => $this->federal_alert_name,
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
            'keywords' => $this->FederalAlertKeywords ? collect($this->FederalAlertKeywords->toArray())->map(function($keyword) {
                    return $keyword['keyword'];
                })->toArray() : [],

            //federal_notices
            'federal_notices' => $this->FederalAlertNotices ? collect($this->FederalAlertNotices->toArray())->map(function($federal_notice) {
                    return $federal_notice['federal_notice_id'];
                })->toArray() : [],

            //federal_naics
            'naics' => $this->FederalAlertNaics ? collect($this->FederalAlertNaics->toArray())->map(function($federal_naics) {
                    return $federal_naics['naics_id'];
                })->toArray() : [],

            //federal_psc
            'pscs' => $this->FederalAlertPscs ? collect($this->FederalAlertPscs->toArray())->map(function($federal_psc) {
                    return $federal_psc['psc_id'];
                })->toArray() : [],

            //federal_states
            'states' => $this->FederalAlertStates ? collect($this->FederalAlertStates->toArray())->map(function($federal_state) {
                    return $federal_state['state_id'];
                })->toArray() : [],

            //federal_set_asides
            'set_asides' => $this->FederalAlertSetAsides ? collect($this->FederalAlertSetAsides->toArray())->map(function($federal_set_aside) {
                    return $federal_set_aside['set_aside_id'];
                })->toArray() : [],

            //federal_agencies
            'federal_agencies' => $this->FederalAlertAgencies ? collect($this->FederalAlertAgencies->toArray())->map(function($federal_agency) {
                    return $federal_agency['federal_agency_id'];
                })->toArray() : []  
        ];
    }
}
