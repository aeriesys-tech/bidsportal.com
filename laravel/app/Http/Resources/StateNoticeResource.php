<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StateNoticeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'state_notice_id' => $this->state_notice_id,
            'notice_name' => $this->notice_name,
            'sort' => $this->sort,
            'background_color' => $this->background_color,
            'status' => $this->deleted_at?false:true
        ];
    }
}