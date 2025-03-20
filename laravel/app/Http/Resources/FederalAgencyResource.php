<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FederalAgencyResource extends JsonResource
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
            'federal_agency_id' => $this->federal_agency_id,
            'agency_name' => $this->agency_name,
            'agency_code' => $this->agency_code,
            'status' => $this->deleted_at?false:true
        ];
    }
}
