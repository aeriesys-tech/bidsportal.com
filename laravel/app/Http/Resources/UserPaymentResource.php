<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserPaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
         return [
            'user_payment_id' => $this->user_payment_id,
            'txn_id' => $this->txn_id,
            'order_id' => $this->order_id,
            'payment_status' => $this->payment_status,
            'payment_date' => $this->payment_date,
            'payment_amount' => $this->payment_amount,
            'purchase_items' => PurchaseItemResource::collection($this->PurchaseItems),
        ];
    }
}
