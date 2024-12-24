<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionPlanResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'subscription_plan_id' => $this->subscription_plan_id,
            'plan' => $this->plan,
            'price' => $this->price,
            'days' => $this->days,
            'month' => $this->month,
            'description' => $this->description,
            'discount' => $this->discount,
            'is_default' => $this->is_default ? true : false
        ];
    }
}
