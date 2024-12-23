<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Models\UserSubscription;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if($this->created_at){
            $date = Carbon::parse($this->created_at); 
            $formatted_date = $date->format('M d, Y'); // 
        }

        $user_subscription = UserSubscription::where('user_id', $this->user_id)->where('active_status', 'like', 'active')->first();
        $subscription = null;
        if($user_subscription){
            $today = Carbon::today();
            if (Carbon::parse($user_subscription->valid_to)->gte($today)) {
                $subscription = 'valid';
            } else {
                $subscription = 'expired';
            }
        }else{
            $user_subscription = null;
        }

        return [
            'user_id' => $this->user_id,
            'name' => $this->name,
            'email' => $this->email,
            'position' => $this->position,
            'company_name' => $this->company_name,
            'phone' => $this->phone,
            'web_address' => $this->web_address,
            'mailing_address' => $this->mailing_address,
            'city' => $this->city,
            'state' => $this->state,
            'pin_code' => $this->pin_code,
            'status' => $this->status,
            'created_at' => $formatted_date,
            'subscription' => $subscription
       ];
    }
}
