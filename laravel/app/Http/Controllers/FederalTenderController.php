<?php

namespace App\Http\Controllers;
use App\Models\FederalTender;
use App\Models\User;
use App\Models\FederalAttachment;
use App\Http\Resources\FederalTenderResource;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\FederalTenderMail;
use App\Http\Resources\FederalTenderDetailResource;
use GuzzleHttp\Client;
use DateTime;
use DateTimeZone;
use App\Models\ApiKey;
use ZipArchive;
use Auth;
use App\Models\FederalOfficeAddress;
use App\Models\FederalContact;

class FederalTenderController extends Controller
{
    public function addAttachments($resource_links){
        foreach ($resource_links as $key => $attachment) {
            $client = new Client();  
            $response = $client->get($attachment); 
            $header=$response->getheaders();
            if(isset($header['Last-Modified']) && count($header['Last-Modified']) > 0){
                $dt = new DateTime($header['Last-Modified'][0], new DateTimeZone('UTC'));
                $last_modified = $dt->format('M d, Y');    
                
            }else{
                $last_modified = null;
            }
        }
    }

    public function updateDescriptions()
    {
        $api_key = ApiKey::first()?->api_key ?? "8UPYOoBOM5C3ZSFpaxt1sIvZ3byn2Jfb91XoGyMT";
        $federal_tenders = FederalTender::whereNull('description')->get();
        if ($federal_tenders->isEmpty()) {
            \Log::info('No federal tenders found with null descriptions.');
            return;
        }

        $client = new Client();
        foreach ($federal_tenders as $federal_tender) {
            try {
                $url = $federal_tender['description_link'] . "&api_key=" . $api_key;

                $response = $client->get($url);
                $responseBody = json_decode($response->getBody(), true);

                $description = $responseBody['description'] ?? null;

                if ($description) {
                    $federal_tender->update(['description' => $description]);
                }

            } catch (\GuzzleHttp\Exception\ClientException $e) {
                \Log::error("Error fetching description for tender ID: {$federal_tender['federal_tender_id']} - " . $e->getMessage());
            } catch (\Exception $e) {
                \Log::error("Unexpected error for tender ID: {$federal_tender['federal_tender_id']} - " . $e->getMessage());
            }
        }
    }


    public function paginateFederalTenders(Request $request)
    {
    	$request->validate([
            'order_by' => 'required',
            'per_page' => 'required|numeric'
        ]);
    	$query = FederalTender::query();

        if ($request->active && $request->expired) {
            $query->whereDate('expiry_date', '>=', now()->toDateString())
              ->orWhereDate('expiry_date', '<', now()->toDateString());
        } elseif ($request->active) {
            $query->whereDate('expiry_date', '>=', now()->toDateString());
        } elseif ($request->expired) {
            $query->whereDate('expiry_date', '<', now()->toDateString());
        }

    	if($request->posted_date && $request->posted_date != 'custom'){
            $previous_date = Carbon::now()->sub(CarbonInterval::createFromDateString($request->posted_date))->format('Y-m-d');
    		$query->whereDate('posted_date', '>=', $previous_date);
    	}

        if($request->posted_from_date && $request->posted_to_date){
            $query->whereDate('posted_date', '>=', $request->posted_from_date)->whereDate('posted_date', '<=', $request->posted_to_date);
        }

        if($request->response_date && $request->response_date != 'custom'){
            $next_date = Carbon::now()->add(CarbonInterval::createFromDateString($request->response_date))->format('Y-m-d');
            $query->whereDate('expiry_date', '<=', $next_date);
        }

        if($request->response_from_date && $request->response_to_date){
            $query->whereDate('expiry_date', '>=', $request->response_from_date)->whereDate('expiry_date', '<=', $request->response_to_date);
        }

    	if(!empty($request->federal_notices)){
    		$query->whereIn('federal_notice_id', $request->federal_notices);
    	}

    	if(!empty($request->naics)){
    		$query->whereIn('naics_id', $request->naics);
    	}

    	if(!empty($request->pscs)){
    		$query->whereIn('psc_id', $request->pscs);
    	}

        if(!empty($request->set_asides)){
            $query->whereIn('set_aside_id', $request->set_asides);
        }

        if(!empty($request->states)){
            $query->whereIn('state_id', $request->states);
        }

        if(!empty($request->federal_agencies)){
            $query->whereIn('federal_agency_id', $request->federal_agencies);
        }

    	if (!empty($request->keywords)) {
            $keywords = is_string($request->keywords)
                ? array_map('trim', explode(',', $request->keywords))
                : array_map('trim', $request->keywords);

            foreach ($keywords as $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->whereRaw(
                        "MATCH(tender_no, title) AGAINST(? IN NATURAL LANGUAGE MODE)",
                        [$keyword]
                    )
                    ->orWhere('tender_no', 'REGEXP', '[[:<:]]' . preg_quote($keyword) . '[[:>:]]')
                    ->orWhere('title', 'REGEXP', '[[:<:]]' . preg_quote($keyword) . '[[:>:]]');
                });
            }

            $query->orderByRaw(
                "MATCH(tender_no, title) AGAINST(? IN NATURAL LANGUAGE MODE) DESC, federal_tender_id DESC",
                [$keyword]
            );
        }

	    $query->orderBy('federal_tender_id', 'DESC');
    	$federal_tenders = $query->paginate($request->per_page); 
        return FederalTenderResource::collection($federal_tenders);
    }

    public function getFederalTender(Request $request)
    {
        $federal_tender = FederalTender::where('federal_tender_id', $request->federal_tender_id)->first();
        return new FederalTenderDetailResource($federal_tender);
    }

    public function sendFederalTenderMail(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required',
            'recipient_email' => ['required', function ($attribute, $value, $fail) {
                $emails = array_map('trim', explode(',', $value));
                foreach ($emails as $email) {
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $fail("The $attribute contains an invalid email: $email");
                    }
                }
            }],
            'subject' => 'required',
            'message' => 'required',
            'federal_tenders' => 'required|array'
        ]);

        if(isset($request->federal_tenders) && !empty($request->federal_tenders)){
            $bids = FederalTender::whereIn('federal_tender_id', $request->federal_tenders)->get();
            $user = User::where('user_id', $request->user_id)->first();
            $emails = array_map('trim', explode(',', $request->recipient_email));
            Mail::to($emails)->send(new FederalTenderMail($bids, $user, $request));

            return response()->json(['status' => 'Email sent successfully!']);
        }else{
            return response()->json(['status' => 'Error sending mail'], 422);
        }
    }

    public function downloadFederalAttachments($federal_tender_id)
    {
        $federal_attachments = FederalAttachment::where('federal_tender_id', $federal_tender_id)->get();
        if(count($federal_attachments)){
            
            $zip_file_name = 'attachments.zip';
            $temp_zip_path = storage_path($zip_file_name);
            $zip = new ZipArchive;
            if ($zip->open($temp_zip_path, ZipArchive::CREATE) === TRUE) {
                foreach ($federal_attachments as $federal_attachment) {
                    $file_contents = file_get_contents($federal_attachment->attachment_url); 
                    $file_name = basename($federal_attachment->attachment_url); 
                    $zip->addFromString($file_name, $file_contents);
                }
                $zip->close();
            } else {
                return response()->json(['error' => 'Failed to create ZIP file'], 500);
            }
            return response()->download($temp_zip_path, $zip_file_name)->deleteFileAfterSend(true);
        }   
    }

    public function paginateTenderFederals(Request $request)
    {
        $request->validate([
            'order_by' => 'required',
            'per_page' => 'required|numeric',
            'keyword' => 'required'
        ]);
        $query = FederalTender::query();
        if (isset($request->status)) {
            if ($request->status === 'All') {
            } elseif ($request->status === 'Active') {
                $query->where('status', true);
            } elseif ($request->status === 'Inactive') {
                $query->where('status', false);
            }
        }
            
        if($request->search!='')
        {
            $query->where('tender_no', 'like', "%$request->search%")->orWhere('opening_date', 'like', "$request->search%")
                ->orWhere('title', 'like', "$request->search%")->orWhere('posted_date', 'like', "$request->search%");
        }
        $federals = $query->orderBy($request->keyword,$request->order_by)->paginate($request->per_page);
        return FederalTenderResource::collection($federals);
    }

    public function addFederalTender(Request $request)
    {
        $data = $request->validate([
            'tender_no' => 'required',
            'title' => 'required|unique:federal_tenders,title',
            'description' => 'nullable',
            'country_id' => 'required',
            'state_id' => 'required',
            'tender_type_id' => 'nullable',
            'federal_notice_id' => 'nullable',
            'category_id' => 'nullable',
            'federal_agency_id' => 'nullable',
            'set_aside_id' => 'nullable',
            'naics_id' => 'nullable',
            'psc_id' => 'nullable',
            'tender_url' => 'nullable',
            'fees' => 'nullable',
            'type_of_award' => 'nullable',
            'place_of_performance' => 'nullable',
            'notice_id' => 'nullable',
            'description_link' => 'nullable',
            'category_name' => 'nullable',
            'notice_name' => 'nullable',
            'agency_name' => 'nullable',
            'is_latest' => 'nullable',
            'primary_address.title' => 'nullable|string|max:255',
            'primary_address.email' => 'nullable',
            'primary_address.phone' => 'nullable',
            'primary_address.full_name' => 'nullable',
            'secondary_address.email' => 'nullable',
            'secondary_address.phone' => 'nullable',
            'secondary_address.title' => 'nullable|string|max:255',
            'secondary_address.full_name' => 'nullable',
            'opening_date' => 'nullable',
            'posted_date' => 'nullable',
            'expiry_date' => 'nullable'
        ]);

        $federal = FederalTender::create($data);

        if($request->federal_office_address)
        {
            $address = json_decode($request->federal_office_address, true);
            FederalOfficeAddress::updateOrCreate([
                'federal_tender_id' => $federal->federal_tender_id,
                'city' => $address['city'],
                'state' => $address['state'],
                'country' => $address['country'],
                'zip_code' => $address['zip_code'] ?? null
            ]);
        }

        if ($request->primary_address) 
        {
            $primaryAddress = json_decode($request->primary_address, true);
            FederalContact::updateOrCreate(
                [
                    'federal_tender_id' => $federal->federal_tender_id,
                    'type' => 'Primary',
                    'email' => $primaryAddress['email'] ?? null,
                    'phone' => $primaryAddress['phone'] ?? null,
                    'title' => $primaryAddress['title'] ?? null,
                    'full_name' => $primaryAddress['full_name'] ?? null,
                ]
            );
        }
    
        if ($request->secondary_address) 
        {
            $secondaryAddress = json_decode($request->secondary_address, true);
            FederalContact::updateOrCreate(
                [
                    'federal_tender_id' => $federal->federal_tender_id,
                    'type' => 'Secondary',
                    'email' => $secondaryAddress['email'] ?? null,
                    'phone' => $secondaryAddress['phone'] ?? null,
                    'title' => $secondaryAddress['title'] ?? null,
                    'full_name' => $secondaryAddress['full_name'] ?? null,
                ]
            );
        }

        if (!empty($request->attachments) && is_array($request->attachments)) {
            foreach ($request->attachments as $attachment) {
                $attachment_name = $attachment->getClientOriginalName();
                $attachment_size = $attachment->getSize();
                $filePath = 'federal/' . $attachment_name; 
                $result = Storage::disk('s3')->put($filePath, file_get_contents($attachment));
        
                if ($result) {
                    $attachment_url = Storage::disk('s3')->url($filePath);
                    if ($attachment_url) {
                        FederalAttachment::updateOrCreate(
                            [
                                'federal_tender_id' => $federal->federal_tender_id,
                                'attachment_name' => $attachment_name,
                            ],
                            [
                                'attachment_size' => $attachment_size,
                                'attachment_date' => now()->format('Y-m-d'),
                                'attachment_url' => $attachment_url,
                            ]
                        );
                    }
                } else {
                    return response()->json([
                        'message' => 'File upload failed',
                    ], 500);
                }
            }
        }
        // return new FederalTenderResource($federal);
    }

    public function updateTenderFederal(Request $request)
    {
        $data = $request->validate([
            'federal_tender_id' => 'required|exists:federal_tenders,federal_tender_id',
            'tender_no' => 'required',
            'title' => 'required',
            'description' => 'nullable',
            'title' => 'nullable',
            'country_id' => 'nullable',
            'state_id' => 'nullable',
            'tender_type_id' => 'nullable',
            'federal_notice_id' => 'nullable',
            'category_id' => 'nullable',
            'federal_agency_id' => 'nullable',
            'set_aside_id' => 'nullable',
            'naics_id' => 'nullable',
            'psc_id' => 'nullable',
            'tender_url' => 'nullable',
            'fees' => 'nullable',
            'type_of_award' => 'nullable',
            'place_of_performance' => 'nullable',
            'notice_id' => 'nullable',
            'description_link' => 'nullable',
            'category_name' => 'nullable',
            'notice_name' => 'nullable',
            'agency_name' => 'nullable',
            'is_latest' => 'nullable',
            'primary_address.title' => 'nullable|string|max:255',
            'primary_address.email' => 'nullable',
            'primary_address.phone' => 'nullable',
            'primary_address.full_name' => 'nullable',
            'secondary_address.email' => 'nullable',
            'secondary_address.phone' => 'nullable',
            'secondary_address.title' => 'nullable|string|max:255',
            'secondary_address.full_name' => 'nullable',
            'opening_date' => 'nullable',
            'posted_date' => 'nullable',
            'expiry_date' => 'nullable'
        ]);

        $federal = FederalTender::where('federal_tender_id', $request->federal_tender_id)->first();
        $federal->update($data);

        if($request->federal_office_address)
        {
            $address = json_decode($request->federal_office_address, true);
            FederalOfficeAddress::updateOrCreate([
                'federal_tender_id' => $federal->federal_tender_id
                ],
                [
                'city' => $address['city'],
                'state' => $address['state'],
                'country' => $address['country'],
                'zip_code' => $address['zip_code'] ?? null
            ]);
        }

        if ($request->primary_address) {
            $primaryAddress = json_decode($request->primary_address, true);
            FederalContact::updateOrCreate(
                [
                    'federal_tender_id' => $federal->federal_tender_id,
                    'type' => 'Primary'
                ],
                [
                    'email' => $primaryAddress['email'] ?? null,
                    'phone' => $primaryAddress['phone'] ?? null,
                    'title' => $primaryAddress['title'] ?? null,
                    'full_name' => $primaryAddress['full_name'] ?? null,
                ]
            );
        }
    
        // Update secondary address
        if ($request->secondary_address) {
            $secondaryAddress = json_decode($request->secondary_address, true);
            FederalContact::updateOrCreate(
                [
                    'federal_tender_id' => $federal->federal_tender_id,
                    'type' => 'Secondary'
                ],
                [
                    'email' => $secondaryAddress['email'] ?? null,
                    'phone' => $secondaryAddress['phone'] ?? null,
                    'title' => $secondaryAddress['title'] ?? null,
                    'full_name' => $secondaryAddress['full_name'] ?? null,
                ]
            );
        }

        if (!empty($request->attachments) && is_array($request->attachments)) {
            foreach ($request->attachments as $attachment) {
                $attachment_name = $attachment->getClientOriginalName();
                $attachment_size = $attachment->getSize();
                $filePath = 'federal/' . $attachment_name; 
                $result = Storage::disk('s3')->put($filePath, file_get_contents($attachment));
    
                if ($result) {
                    $attachment_url = Storage::disk('s3')->url($filePath);
                    if ($attachment_url) {
                        FederalAttachment::updateOrCreate(
                            [
                                'federal_tender_id' => $federal->federal_tender_id,
                                'attachment_name' => $attachment_name,
                            ],
                            [
                                'attachment_size' => $attachment_size,
                                'attachment_date' => now()->format('Y-m-d'),
                                'attachment_url' => $attachment_url,
                            ]
                        );
                    }
                } else {
                    return response()->json([
                        'message' => 'File upload failed',
                    ], 500);
                }
            }
        }
        return response()->json([
            'message' => 'Federal Tender updated successfully',
        ]);
    }

    public function updateFederalTender(Request $request)
    {
        $request->validate([
            'federal_tender_id' => 'required',
            'federal_notice_id' => 'required',
            'category_id' => 'required',
            'state_id' => 'required'
        ]);

        try{
            $update_state_tender = FederalTender::where('federal_tender_id', $request->federal_tender_id)->update([
                'federal_notice_id' => $request->federal_notice_id,
                'federal_agency_id' => $request->federal_agency_id,
                'category_id' => $request->category_id,
                'state_id' => $request->state_id,
                'status' => true
            ]);
            if($update_state_tender){
                return response()->json([
                    'message' => 'Tender updated successfully'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the tender',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteFederalTender(Request $request)
    {
        $request->validate([
            'federal_tender_id' => 'required|exists:federal_tenders,federal_tender_id'
        ]);

        FederalOfficeAddress::where('federal_tender_id', $request->federal_tender_id)->forceDelete();
        FederalContact::where('federal_tender_id', $request->federal_tender_id)->forceDelete();
        FederalAttachment::where('federal_tender_id', $request->federal_tender_id)->forceDelete();
        FederalTender::where('federal_tender_id', $request->federal_tender_id)->forceDelete();
        return response()->json([
            "message" => "FederalTender Deleted Successfully"
        ]);
    }

    public function deleteFederalTenders(Request $request){
        FederalOfficeAddress::whereIn('federal_tender_id', $request->delete_tenders)->delete();
        FederalContact::whereIn('federal_tender_id', $request->delete_tenders)->delete();
        FederalAttachment::whereIn('federal_tender_id', $request->delete_tenders)->delete();
        return FederalTender::whereIn('federal_tender_id', $request->delete_tenders)->delete();
    }
}
