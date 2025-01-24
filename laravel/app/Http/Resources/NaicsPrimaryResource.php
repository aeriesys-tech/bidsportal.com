<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NaicsPrimaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "naics_id"=>$this->naics_id,
            "naics_parent_id"=>$this->naics_parent_id,
            "naics_code"=>$this->naics_code,                             
            "name"=>$this->naics_code.' '.$this->naics_description
        ];
    }
}
