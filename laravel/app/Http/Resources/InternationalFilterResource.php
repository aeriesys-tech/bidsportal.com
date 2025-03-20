<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InternationalFilterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'international_filter_id' => $this->international_filter_id,
            'international_filter_name' => $this->international_filter_name,
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
        'keywords' => $this->InternationalFilterKeywords ? collect($this->InternationalFilterKeywords->toArray())->map(function($keyword) {
                return $keyword['keyword'];
        })->toArray() : [],

        //international_notices
        'international_notices' => $this->InternationalFilterNotices ? collect($this->InternationalFilterNotices->toArray())->map(function($state_notice) {
            return $state_notice['international_notice_id'];
        })->toArray() : [],

        //international_states
        'states' => $this->InternationalFilterStates ? collect($this->InternationalFilterStates->toArray())->map(function($international_state) {
                return $international_state['state_id'];
        })->toArray() : [],

        //categories
        'categories' => $this->Categories ? collect($this->Categories->toArray())->map(function($state_set_aside) {
                return $state_set_aside['category_id'];
            })->toArray() : [],

        //international_agencies
        'international_agencies' => $this->InternationalFilterAgencies ? collect($this->InternationalFilterAgencies->toArray())->map(function($state_agency) {
                return $state_agency['international_agency_id'];
            })->toArray() : []  
        ];
    }
}
