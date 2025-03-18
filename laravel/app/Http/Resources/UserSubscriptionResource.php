<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class UserSubscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($this->valid_to){
            $valid_to = Carbon::parse($this->valid_to); 
            $now = Carbon::now();
            $diff = $now->diff($valid_to);
            $months_left = $diff->m; 
            $days_left = $diff->d; 
            $is_future = $valid_to->isFuture();
            $formatted_expiry_date = $valid_to->format('M d, Y'); 
            // Format the output for months and days
            if($months_left > 0){
                $time_left = $is_future ? "{$months_left} month(s) and {$days_left} day(s)" : "Expired";
            }else{
                $time_left = $is_future ? "{$days_left} day(s)" : "Expired";
            }
        } else{
            $valid_to = null;
            $formatted_expiry_date = null;
            $months_left = null;
            $time_left = null; 
        }

        if($this->valid_from){
            $valid_from = Carbon::parse($this->valid_from); 
            $formatted_valid_from_date = $valid_from->format('M d, Y'); 
        }else{
            $formatted_valid_from_date = null;
        } 

        return [
            'user_subscription_id' => $this->user_subscription_id,
            'user_id' => $this->user_id,
            'user' => new UserResource($this->User),
            'order_id' => $this->order_id,
            'payment_method' => $this->payment_method,
            'active_status' => $this->active_status,
            'validity' => $this->validity,
            'valid_from' => $this->valid_from,
            'valid_to' => $this->valid_to,
            'time_left' => $time_left,
            'item_number' => $this->item_number,
            'txn_id' => $this->txn_id,
            'ipn_track_id' => $this->ipn_track_id,
            'payment_gross' => $this->payment_gross,
            'currency_code' => $this->currency_code,
            'subscription_plan_id' => $this->subscription_plan_id,
            'subscription_plan' => $this->SubscriptionPlan,
            'payer_email' => $this->payer_email,
            'payment_status' => $this->payment_status,
            'subscr_month' => $this->subscr_month,
            'payment_date' => $this->payment_date,
            'created_date' => $this->created_date
        ];
    }
}
