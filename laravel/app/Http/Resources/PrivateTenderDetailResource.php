<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class PrivateTenderDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if (isset($this->PrivateOfficeAddress)) {
            $private_office_address = $this->PrivateOfficeAddress;
        } else {
            $private_office_address = [
                'city' => null,
                'state' => null,
                'country' => null
            ];
        }

        if(isset($this->PrivateContactPrimary))
        {
            $primary_address = $this->PrivateContactPrimary;
        }
        else{
            $primary_address = [
                'title' => $this->PrivateContactPrimary->title ?? null,
                'type' => $this->PrivateContactPrimary->type ?? null,
                'email' => $this->PrivateContactPrimary->email ?? null,
                'phone' => $this->PrivateContactPrimary->phone ?? null,
                'full_name' => $this->PrivateContactPrimary->full_name ?? null,
            ];
        }

        if(isset($this->PrivateContactSecondary))
        {
            $secondary_address = $this->PrivateContactSecondary;
        }
        else{
            $secondary_address = [
                'title' => $this->PrivateContactSecondary->title ?? null,
                'type' => $this->PrivateContactSecondary->type ?? null,
                'email' => $this->PrivateContactSecondary->email ?? null,
                'phone' => $this->PrivateContactSecondary->phone ?? null,
                'full_name' => $this->PrivateContactSecondary->full_name ?? null,
            ];
        }
        return [
            'private_tender_id' => $this->private_tender_id,
            'tender_no' => $this->tender_no,
            'title' => $this->title,
            'description' => $this->description,
            'opening_date' => $this->opening_date,
            'posted_date' => $this->posted_date,
            'expiry_date' => $this->expiry_date ? Carbon::parse($this->expiry_date)->format('Y-m-d') : null,
            'country_id' => $this->country_id,
            'state_id' => $this->state_id,
            'state' => new StateResource($this->State),
            'private_tender_id' => $this->private_tender_id,
            'private_notice_id' => $this->private_notice_id,
            'state_notice' => $this->StateNotice,
            'category_id' => $this->category_id,
            'private_agency_id' => $this->private_agency_id,
            'private_agency' => $this->PrivateAgency,
            'set_aside_id' => $this->set_aside_id,
            'tender_url' => $this->tender_url,
            'fees' => $this->fees,
            'type_of_award' => $this->type_of_award,
            'place_of_performance' => $this->place_of_performance,
            'notice_id' => $this->notice_id,
            'description_link' => $this->description_link,
            'category_name' => $this->category_name,
            'notice_name' => $this->notice_name,
            'agency_name' => $this->agency_name,
            'private_office_address' => $private_office_address,
            'private_notice' => $this->PrivateNotice,
            'category' => $this->Category,
            'set_aside' => $this->SetAside,
            'naics' => $this->Naics,
            'psc' => $this->Psc,
            'private_attachments' => PrivateAttachmentResource::collection($this->PrivateAttachments),
            'private_contacts' => $this->PrivateContacts,
            'status' => $this->status?true:false,
            'primary_address' => $primary_address,
            'secondary_address' => $secondary_address
        ];
    }
}
