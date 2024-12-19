<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PrivateFilterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'private_filter_id' => $this->private_filter_id,
            'private_filter_name' => $this->private_filter_name,
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
        'keywords' => $this->PrivateFilterKeywords ? collect($this->PrivateFilterKeywords->toArray())->map(function($keyword) {
                return $keyword['keyword'];
        })->toArray() : [],

        //private_notices
        'private_notices' => $this->PrivateFilterNotices ? collect($this->PrivateFilterNotices->toArray())->map(function($state_notice) {
            return $state_notice['private_notice_id'];
        })->toArray() : [],

        //private_states
        'states' => $this->PrivateFilterStates ? collect($this->PrivateFilterStates->toArray())->map(function($private_state) {
                return $private_state['state_id'];
        })->toArray() : [],

        //categories
        'categories' => $this->Categories ? collect($this->Categories->toArray())->map(function($state_set_aside) {
                return $state_set_aside['category_id'];
            })->toArray() : [],

        //private_agencies
        'private_agencies' => $this->PrivateFilterAgencies ? collect($this->PrivateFilterAgencies->toArray())->map(function($state_agency) {
                return $state_agency['private_agency_id'];
            })->toArray() : []  
        ];
    }
}
