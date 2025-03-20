<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StateFilterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'state_filter_id' => $this->state_filter_id,
            'state_filter_name' => $this->state_filter_name,
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
            'keywords' => $this->StateFilterKeywords ? collect($this->StateFilterKeywords->toArray())->map(function($keyword) {
                    return $keyword['keyword'];
                })->toArray() : [],

            //state_notices
            'state_notices' => $this->StateFilterNotices ? collect($this->StateFilterNotices->toArray())->map(function($state_notice) {
                    return $state_notice['state_notice_id'];
                })->toArray() : [],

            //state_states
            'states' => $this->StateFilterStates ? collect($this->StateFilterStates->toArray())->map(function($state_state) {
                    return $state_state['state_id'];
                })->toArray() : [],

            //categories
            'categories' => $this->Categories ? collect($this->Categories->toArray())->map(function($state_set_aside) {
                    return $state_set_aside['category_id'];
                })->toArray() : [],

            //state_agencies
            'state_agencies' => $this->StateFilterAgencies ? collect($this->StateFilterAgencies->toArray())->map(function($state_agency) {
                    return $state_agency['state_agency_id'];
                })->toArray() : []  
        ];
    }
}
