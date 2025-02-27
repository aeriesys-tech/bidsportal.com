<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use Carbon\CarbonInterval;

class PrivateTenderResource extends JsonResource
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

        if($this->expiry_date && now()->lte($this->expiry_date)){
            $is_expired = false;
            $date1 = Carbon::parse(now());
            $date2 = Carbon::parse($this->expiry_date);
            $days_difference = round($date1->diffInDays($date2) + 1);
        }else{
            $is_expired = true;
            $days_difference = null;
        }

        $cart_icon = false;
        

        return [
            'private_tender_id' => $this->private_tender_id,
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
            'private_notice_id' => $this->private_notice_id,
            'private_notice' => $this->PrivateNotice,
            'category_id' => $this->category_id,
            'private_agency_id' => $this->private_agency_id,
            'private_agency' => $this->PrivateAgency,
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
