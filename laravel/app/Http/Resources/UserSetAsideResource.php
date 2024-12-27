<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserSetAsideResource extends JsonResource
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
            'user_set_aside_id' => $this->user_set_aside_id,
            'user_id' => $this->user_id,
            'set_aside_id' => $this->set_aside_id,
            'set_aside' => new SetAsideResource($this->SetAside)
        ];
    }
}
