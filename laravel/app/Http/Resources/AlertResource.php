<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AlertResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'alert_id' => $this->alert_id,
            'alert_title' => $this->alert_title,
            'frequency' => $this->frequency,
            'region' => $this->region,
            'user_id' => $this->user_id,
            'posted_date' => $this->posted_date,
            'active' => $this->active ? true : false,
            'expired' => $this->expired ? true : false,
            'posted_from_date' => $this->posted_from_date,
            'posted_to_date' => $this->posted_to_date,
            'response_date' => $this->response_date,
            'response_from_date' => $this->response_from_date,
            'response_to_date' => $this->response_to_date,
            'status' => $this->status, // Added missing comma here

            //keywords
            'keywords' => $this->AlertKeywords ? collect($this->AlertKeywords->toArray())->map(function($keyword) {
                return $keyword['keyword'];
            })->toArray() : [],

            //federal_notices
            'federal_notices' => $this->FederalAlertNotices ? collect($this->FederalAlertNotices->toArray())->map(function($federal_notice) {
                return $federal_notice['federal_notice_id'];
            })->toArray() : [],

            //federal_naics
            'naics' => $this->AlertNaics ? collect($this->AlertNaics->toArray())->map(function($federal_naics) {
                return $federal_naics['naics_id'];
            })->toArray() : [],

            //federal_psc
            'pscs' => $this->AlertPscs ? collect($this->AlertPscs->toArray())->map(function($federal_psc) {
                return $federal_psc['psc_id'];
            })->toArray() : [],

            //federal_states
            'states' => $this->AlertStates ? collect($this->AlertStates->toArray())->map(function($federal_state) {
                return $federal_state['state_id'];
            })->toArray() : [],

            //federal_set_asides
            'set_asides' => $this->AlertSetAsides ? collect($this->AlertSetAsides->toArray())->map(function($federal_set_aside) {
                return $federal_set_aside['set_aside_id'];
            })->toArray() : [],

            //federal_agencies
            'federal_agencies' => $this->FederalAlertAgencies ? collect($this->FederalAlertAgencies->toArray())->map(function($federal_agency) {
                return $federal_agency['federal_agency_id'];
            })->toArray() : []
        ];
    }
}
