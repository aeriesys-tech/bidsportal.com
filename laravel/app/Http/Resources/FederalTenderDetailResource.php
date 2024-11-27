<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class FederalTenderDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if (isset($this->FederalOfficeAddress)) {
            $federal_office_address = $this->FederalOfficeAddress;
        } else {
            $federal_office_address = [
                'city' => null,
                'state' => null,
                'country' => null
            ];
        }

        if(isset($this->FederalContactPrimary))
        {
            $primary_address = $this->FederalContactPrimary;
        }
        else{
            $primary_address = [
                'title' => $this->FederalContactPrimary->title ?? null,
                'type' => $this->FederalContactPrimary->type ?? null,
                'email' => $this->FederalContactPrimary->email ?? null,
                'phone' => $this->FederalContactPrimary->phone ?? null,
                'full_name' => $this->FederalContactPrimary->full_name ?? null,
            ];
        }

        if(isset($this->FederalContactSecondary))
        {
            $secondary_address = $this->FederalContactSecondary;
        }
        else{
            $secondary_address = [
                'title' => $this->FederalContactSecondary->title ?? null,
                'type' => $this->FederalContactSecondary->type ?? null,
                'email' => $this->FederalContactSecondary->email ?? null,
                'phone' => $this->FederalContactSecondary->phone ?? null,
                'full_name' => $this->FederalContactSecondary->full_name ?? null,
            ];
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
            'state' => new StateResource($this->State),
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
            'place_of_performance' => $this->place_of_performance,
            'notice_id' => $this->notice_id,
            'description_link' => $this->description_link,
            'category_name' => $this->category_name,
            'notice_name' => $this->notice_name,
            'agency_name' => $this->agency_name,
            'federal_office_address' => $federal_office_address,
            'federal_notice' => $this->FederalNotice,
            'category' => $this->Category,
            'set_aside' => $this->SetAside,
            'naics' => $this->Naics,
            'psc' => $this->Psc,
            'federal_attachments' => FederalAttachmentResource::collection($this->FederalAttachments),
            'federal_contacts' => $this->FederalContacts,
            'primary_address' => $primary_address,
            'secondary_address' => $secondary_address
        ];
    }
    }
}
