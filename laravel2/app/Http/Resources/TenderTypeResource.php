<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TenderTypeResource extends JsonResource
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
            'federal_tender_id' => $this->federal_tender_id,
            'tender_no' => $this->tender_no,
            'description' => $this->description,
            'opening_date' => $this->opening_date
        ];
    }
}
