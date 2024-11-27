<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       	return [
            'admin_id' => $this->admin_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'mobile1' => $this->mobile1,
            'mobile2' => $this->mobile2,
            'role' => $this->role,
            'created_on' => $this->created_on,
            'last_login' => $this->last_login,
            'last_seen' => $this->last_seen,
            'last_edited' => $this->last_edited,
            'status' => $this->status?true:false
        ];
    }
}
