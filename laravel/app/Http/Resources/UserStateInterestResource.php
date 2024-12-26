<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserStateInterestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_state_interest_id' => $this->user_state_interest_id,
            'user_id' => $this->user_id,
            'state_tender_id' => $this->state_tender_id,
            'interest_type' => $this->interest_type,
            'user' => new UserResource($this->User),
            'status' => false
        ];
    }
}
