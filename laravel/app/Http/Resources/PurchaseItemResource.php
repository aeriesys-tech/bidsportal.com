<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'purchase_item_id' => $this->purchase_item_id,
            'federal_tender_id' => $this->federal_tender_id,
            'federal_tender' => $this->FederalTender,
            'state_tender_id' => $this->state_tender_id,
            'state_tender' => $this->StateTender
        ];
    }
}
