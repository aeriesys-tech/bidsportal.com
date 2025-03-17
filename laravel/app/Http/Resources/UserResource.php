<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Models\UserSubscription;
use App\Models\UserSetAside;

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
            $formatted_date = $date->format('M d, Y'); 
        }else{
            $formatted_date = null;
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

        $set_asides = UserSetAside::where('user_id', $this->user_id)->pluck('set_aside_id')->implode(',');
        if($set_asides){
            $set_asides_arr = explode(",", $set_asides);
            $user_set_asides = UserSetAsideResource::collection($this->UserSetAsides);
        }else{
            $set_asides_arr = [];
            $user_set_asides = [];
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
            'subscription' => $subscription,
            'set_asides' => $set_asides_arr,
            'user_set_asides' => $user_set_asides,
            'email_varified_at' => 'test'
       ];
    }
}
