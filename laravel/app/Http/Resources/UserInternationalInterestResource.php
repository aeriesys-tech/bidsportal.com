<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserInternationalInterestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_international_interest_id' => $this->user_international_interest_id,
            'user_id' => $this->user_id,
            'international_tender_id' => $this->international_tender_id,
            'interest_type' => $this->interest_type,
            'user' => new UserResource($this->User),
            'status' => false
        ];
    }
}
