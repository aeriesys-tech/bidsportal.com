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
        $valid_to = Carbon::parse($this->valid_to); 
        $now = Carbon::now();
        $diff = $now->diff($valid_to);
        $months_left = $diff->m; // Get months
        $days_left = $diff->d; // Get days
        $is_future = $valid_to->isFuture(); // Check if the date is in the future

        // Format the output for months and days
        $time_left = $is_future ? "{$months_left} month(s) and {$days_left} day(s)" : "Expired";

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
