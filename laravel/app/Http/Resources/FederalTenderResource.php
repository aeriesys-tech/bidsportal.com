<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Models\CartItem;

class FederalTenderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $time_ago = null;
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

        $opening_date_parsed = $this->opening_date ? Carbon::parse($this->opening_date)->format('M d, Y') : '-';
        $posted_date_parsed = $this->posted_date ? Carbon::parse($this->posted_date)->format('M d, Y') : '-';
        $expiry_date_parsed = $this->expiry_date ? Carbon::parse($this->expiry_date)->format('M d, Y') : '-';
        $expiry_date = $this->expiry_date ? Carbon::parse($this->expiry_date)->format('Y-m-d') : null;

        $place_of_performance = null;
        if($this->FederalPlaceOfPerformance){
            if($this->FederalPlaceOfPerformance->city_name){
                $place_of_performance = $this->FederalPlaceOfPerformance->city_name;                
            }

            if($this->FederalPlaceOfPerformance->state_name){
                $place_of_performance = $place_of_performance ? $place_of_performance.', '.$this->FederalPlaceOfPerformance->state_name : $this->FederalPlaceOfPerformance->state_name;
            }

            if($this->FederalPlaceOfPerformance->country_name){
                $place_of_performance = $place_of_performance ? $place_of_performance.', '.$this->FederalPlaceOfPerformance->country_name : $this->FederalPlaceOfPerformance->country_name;
            }

        } else if($this->FederalOfficeAddress && !$place_of_performance){
            if($this->FederalOfficeAddress->city){
                $place_of_performance = $this->FederalOfficeAddress->city;                
            }

            if($this->FederalOfficeAddress->state){   
                $place_of_performance = $place_of_performance ?  $place_of_performance.', '.$this->FederalOfficeAddress->state : $this->FederalOfficeAddress->state;
            }

            if($this->FederalOfficeAddress->country){
                $place_of_performance = $place_of_performance ? $place_of_performance.', '.$this->FederalOfficeAddress->country : $this->FederalOfficeAddress->country;
            }            
        } else{
            $place_of_performance = null;
        }

        // if($request->user_id){
        //     $cutoff_date = Carbon::now()->subDays(30);
        //     $cart_item = CartItem::where('user_id', $request->user_id)->where('federal_tender_id', $this->federal_tender_id)->where('cart_item_date', '>=', $cutoff_date)->first();
        //     if($cart_item){
        //         $cart_icon = false;
        //     }else{
        //         $cart_icon = true;
        //     }
        // }else{
        //     $cart_icon = true;
        // }
        $cart_icon = false;

        $notice_colors = [
            'Award Notice' => '#2569f9',
            'Request for Proposal' => 'green',
            'Request for Information' => 'yellow'
        ];

        if($this->FederalNotice){
            $federal_notice_color = $this->FederalNotice->notice_name ?? '';
            $federal_notice_color = $notice_colors[$federal_notice_color] ?? 'gray';            
        }else{
            $federal_notice_color = '';
        }

        return [
            'federal_tender_id' => $this->federal_tender_id,
            'tender_no' => $this->tender_no,
            'title' => $this->title,
            'description' => $this->description,
            'opening_date' => $this->opening_date,
            'posted_date' => $this->posted_date,
            'expiry_date' => $this->expiry_date,
            'country_id' => $this->country_id,
            'state_id' => $this->state_id,
            'federal_tender_id' => $this->federal_tender_id,
            'federal_notice_id' => $this->federal_notice_id,
            'federal_notice' => $this->FederalNotice,
            'category_id' => $this->category_id,
            'federal_agency_id' => $this->federal_agency_id,
            'federal_agency' => $this->FederalAgency,
            'set_aside_id' => $this->set_aside_id,
            'naics_id' => $this->naics_id,
            'psc_id' => $this->psc_id,
            'tender_url' => $this->tender_url,
            'fees' => $this->fees,
            'type_of_award' => $this->type_of_award,
            'place_of_performance' => $place_of_performance,
            'notice_id' => $this->notice_id,
            'description_link' => $this->description_link,
            'category_name' => $this->category_name,
            'notice_name' => $this->notice_name,
            'agency_name' => $this->agency_name,
            'time_ago'  => $time_ago,
            'days_difference' => $days_difference,
            'federal_attachments' => $this->FederalAttachments,
            'federal_office_address' => $this->FederalOfficeAddress,
            'cart_icon' => $cart_icon,
            'is_expired' => $is_expired,
            'opening_date_parsed' => $opening_date_parsed,
            'posted_date_parsed' => $posted_date_parsed,
            'expiry_date_parsed' => $expiry_date_parsed,
            'federal_notice_color' => $federal_notice_color
        ];
    }
}
