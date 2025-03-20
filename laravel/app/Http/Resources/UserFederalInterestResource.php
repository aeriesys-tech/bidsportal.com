<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserFederalInterestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_federal_interest_id' => $this->user_federal_interest_id,
            'user_id' => $this->user_id,
            'federal_tender_id' => $this->federal_tender_id,
            'interest_type' => $this->interest_type,
            'user' => new UserResource($this->User),
            'status' => false
        ];
    }
}
