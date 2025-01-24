<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PscPrimaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "psc_id"=>$this->psc_id,
            "psc_parent_id"=>$this->psc_parent_id,                             
            "psc_code"=>$this->psc_code,                             
            "name"=>$this->psc_code.' '.$this->psc_description                    
        ];
    }
}
