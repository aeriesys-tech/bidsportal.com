<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\FederalTender;
use App\Models\StateTender;

class CartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
    	
        $federal_tender = FederalTender::where('federal_tender_id', $this->federal_tender_id)->first();
        $state_tender = StateTender::where('state_tender_id', $this->state_tender_id)->first();
        return [
            "cart_item_id"=>$this->cart_item_id,
            "user_id"=>$this->user_id,
            "federal_tender_id" => $this->federal_tender_id,
            "state_tender_id" => $this->state_tender_id,
            "federal_tender" => $federal_tender,
            "state_tender" => $state_tender,
            "region" => $this->region,
            "cart_item_date" => $this->cart_item_date           
        ];
    }
}
