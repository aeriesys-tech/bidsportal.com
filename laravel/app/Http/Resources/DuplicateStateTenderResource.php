<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DuplicateStateTenderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'duplicate_state_tender_id' => $this->duplicate_state_tender_id,
            'tender_no' => $this->tender_no,
            'title' => $this->title,
            'posted_date' => $this->posted_date,
            'tender_url' => $this->tender_url
        ];
    }
}
