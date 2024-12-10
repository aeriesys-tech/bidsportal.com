<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;


class StateTenderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($this->posted_date) {
            if($request->time_zone) {
                $difference = Carbon::parse($this->posted_date)
                    ->setTimezone($request->time_zone);
            } else {
                $difference = Carbon::parse($this->posted_date)
                    ->setTimezone('Asia/Kolkata');
            }

            $time_ago  = $difference->diffForHumans();
        }

        if ($this->posted_date && $this->expiry_date) {
            $date1 = Carbon::parse($this->posted_date);
            $date2 = Carbon::parse($this->expiry_date);

            if ($date1->lessThan($date2)) {
                $days_difference = round($date1->diffInDays($date2) + 1); 
            } else if ($date2->lessThan($date1)){
                $days_difference = round($date2->diffInDays($date1) + 1); 
            } else  {
                $days_difference = null; 
            }
        } else {
            $days_difference = null;
        }

        $cart_icon = false;
        // if($request->user_id){
        //     $cutoff_date = Carbon::now()->subDays(30);
        //     $cart_item = CartItem::where('user_id', $request->user_id)->where('state_tender_id', $this->state_tender_id)->where('cart_item_date', '>=', $cutoff_date)->first();
        //     if($cart_item){
        //         $cart_icon = false;
        //     }else{
        //         $cart_icon = true;
        //     }
        // }else{
        //     $cart_icon = true;
        // }

        return [
            'state_tender_id' => $this->state_tender_id,
            'tender_no' => $this->tender_no,
            'title' => $this->title,
            'description' => $this->description,
            'opening_date' => $this->opening_date,
            'posted_date' => $this->posted_date,
            'expiry_date' => $this->expiry_date,
            'country_id' => $this->country_id,
            'country' => $this->Country,
            'state_id' => $this->state_id,
            'state' => $this->State,
            'state_notice_id' => $this->state_notice_id,
            'state_notice' => $this->StateNotice,
            'category_id' => $this->category_id,
            'state_agency_id' => $this->state_agency_id,
            'state_agency' => $this->StateAgency,
            'tender_url' => $this->tender_url,
            'fees' => $this->fees,
            'type_of_award' => $this->type_of_award,
            'place_of_performance' => $this->place_of_performance,
            'notice_id' => $this->notice_id,
            'description_link' => $this->description_link,
            'category_name' => $this->category_name,
            'notice_name' => $this->notice_name,
            'agency_name' => $this->agency_name,
            'time_ago'  => $time_ago,
            'days_difference' => $days_difference,
            'state_attachments' => $this->StateAttachments,
            'cart_icon' => $cart_icon
        ];
    }
}
