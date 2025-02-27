<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FederalFilterAgencyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        protected $fillable = [
            'federal_filter_id',
            'federal_agency_id'
        ];

        protected $primaryKey = 'federal_filter_agency_id';
    }
}
