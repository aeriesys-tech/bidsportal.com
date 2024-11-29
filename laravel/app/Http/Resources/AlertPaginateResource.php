<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AlertPaginateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'alert_id' => $this->alert_id,
            'alert_title' => $this->alert_title,
            'region' => $this->region,
            'frequency' => $this->frequency,
            'user_id' => $this->user_id,
            'user' => $this->User,
            'posted_date' => $this->posted_date,
            'active' => $this->active ? true : false,
            'expired' => $this->expired ? true : false,
            'posted_from_date' => $this->posted_from_date,
            'posted_to_date' => $this->posted_to_date,
            'response_date' => $this->response_date,
            'response_from_date' => $this->response_from_date,
            'response_to_date' => $this->response_to_date,
            'status' => $this->status ? true : false,
        ];
    }
}
