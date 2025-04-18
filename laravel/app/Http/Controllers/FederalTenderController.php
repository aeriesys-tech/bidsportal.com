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
<<<<<<< HEAD
use App\Models\Naics;
=======
>>>>>>> 398cfda8168c8c0dd008c8351ff486428ba935fc
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use App\Jobs\TenderProcess;
use App\Jobs\UpdateFederalDescriptionJob;
use Queue;

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

    public function getFederalTenderbyTenderNo(Request $request)
    {
        $data = $request->validate([
            'tender_no' => 'required:exists,state_tenders'
        ]);
        $federal_tender = FederalTender::where('tender_no', $request->tender_no)->first();
        return new FederalTenderDetailResource($federal_tender);
    }

    public function updateDescriptions()
    {
        $api_key = ApiKey::first()?->api_key ?? "8UPYOoBOM5C3ZSFpaxt1sIvZ3byn2Jfb91XoGyMT";
        $federal_tenders = FederalTender::whereNull('description')->orderBy('posted_date', 'DESC')->take(500)->get();
        if ($federal_tenders->isEmpty()) {
            \Log::info('No federal tenders found with null descriptions.');
            return;
        }

        $client = new Client();
        foreach ($federal_tenders as $federal_tender) {
            UpdateFederalDescriptionJob::dispatch($federal_tender['federal_tender_id']);
            // try {
            //     $url = $federal_tender['description_link'] . "&api_key=" . $api_key;

            //     $response = $client->get($url);
            //     $responseBody = json_decode($response->getBody(), true);

            //     $description = $responseBody['description'] ?? null;

            //     if ($description) {
            //         $federal_tender->update(['description' => $description]);
            //     }

            // } catch (\GuzzleHttp\Exception\ClientException $e) {
            //     \Log::error("Error fetching description for tender ID: {$federal_tender['federal_tender_id']} - " . $e->getMessage());
            // } catch (\Exception $e) {
            //     \Log::error("Unexpected error for tender ID: {$federal_tender['federal_tender_id']} - " . $e->getMessage());
            // }
        }
    }

    public function updateFederalTenderNumber(){
        FederalTender::whereNotNull('tender_no')->update([
            'tender_number' => DB::raw("REPLACE(tender_no, '-', '')")
        ]);
    }

    public function paginateFederalTenders(Request $request)
    {
        $request->validate([
            'order_by' => 'required',
            'per_page' => 'required|numeric'
        ]);
        $query = FederalTender::query();
        if($request->role == 'admin'){
            if ($request->status == 'All') {
                $query->whereDate('expiry_date', '>=', now()->toDateString())
                  ->orWhereDate('expiry_date', '<', now()->toDateString());
            } elseif ($request->status == 'Inactive') {
                $query->whereDate('expiry_date', '>=', now()->toDateString());
            } elseif ($request->status == 'Active') {
                $query->whereDate('expiry_date', '<', now()->toDateString());
            }

            if (!empty($request->search)) 
            {
                $searchQuery = $request->search . '*';  
                $query->whereRaw("MATCH(tender_no, title) AGAINST(? IN NATURAL LANGUAGE MODE)", [$searchQuery])
                    ->orderByRaw("MATCH(tender_no, title) AGAINST(? IN NATURAL LANGUAGE MODE) DESC, federal_tender_id DESC", [$searchQuery]);
            }

            if ($request->keyword == 'notice_name') {
                $query->join('federal_notices', 'federal_tenders.federal_notice_id', '=', 'federal_notices.federal_notice_id')
                        ->select('federal_tenders.*', 'federal_notices.notice_name') 
                      ->orderBy('federal_notices.notice_name', $request->order_by);
            } 
            if ($request->keyword == 'agency_name') {
                $query->join('federal_agencies', 'federal_tenders.federal_agency_id', '=', 'federal_agencies.federal_agency_id')
                        ->select('federal_tenders.*', 'federal_agencies.agency_name') 
                      ->orderBy('federal_agencies.agency_name', $request->order_by);
            } else {
                $query->orderBy($request->keyword, $request->order_by);
            }
        }else{
            if ($request->active && $request->expired) {
<<<<<<< HEAD
                $query->where(function ($q) use ($request) {
                    $q->whereDate('expiry_date', '>=', now()->toDateString())
                    ->orWhereDate('expiry_date', '<', now()->toDateString());
                });
=======
                $query->whereDate('expiry_date', '>=', now()->toDateString())
                  ->orWhereDate('expiry_date', '<', now()->toDateString());
>>>>>>> 398cfda8168c8c0dd008c8351ff486428ba935fc
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
<<<<<<< HEAD

            if($request->response_from_date && $request->response_to_date){
                $query->whereDate('expiry_date', '>=', $request->response_from_date)->whereDate('expiry_date', '<=', $request->response_to_date);
            }

            if(!empty($request->federal_notices)){
                $query->whereIn('federal_notice_id', $request->federal_notices);
            }

            if(!empty($request->naics)){
                $child_naics_ids  = Naics::whereIn('naics_parent_id', $request->naics)->pluck('naics_id')->toArray();
                $all_naics_ids = array_unique(array_merge($request->naics, $child_naics_ids));
                $query->whereIn('naics_id', $all_naics_ids);
            }

            if(!empty($request->pscs)){
                $child_psc_ids = Psc::whereIn('psc_parent_id', $request->pscs)->pluck('psc_id')->toArray();
                $all_psc_ids = array_unique(array_merge($request->pscs, $child_psc_ids)); 
                $query->whereIn('psc_id', $all_psc_ids);
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
                if (is_string($request->keywords)) {
                    $keywords = array_map('trim', explode(',', $request->keywords));
                } else {
                    $keywords = array_map('trim', $request->keywords);
                }

                $query->where(function ($q) use ($keywords) {
                    // First, exact match within existing filters
                    $q->where(function ($subQuery) use ($keywords) {
                        foreach ($keywords as $keyword) {
                            $subQuery->orWhere('tender_no', $keyword)
                                     ->orWhere('tender_number', $keyword);
                        }
                    });

                    // Then, broader search within existing filters
                    $q->orWhere(function ($subQuery) use ($keywords) {
                        foreach ($keywords as $keyword) {
                            $subQuery->orWhere('tender_no', 'like', "%$keyword%")
                                     ->orWhere('tender_number', 'like', "%$keyword%")
                                     ->orWhere('title', 'like', "%$keyword%");
                        }
                    });
                });
=======

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
                if (is_string($request->keywords)) {
                    $keywords = array_map('trim', explode(',', $request->keywords));
                } else {
                    $keywords = array_map('trim', $request->keywords);
                }

                // Exact match first
                $query->where(function ($q) use ($keywords) {
                    foreach ($keywords as $keyword) {
                        $q->orWhere('tender_no', $keyword)
                          ->orWhere('tender_number', $keyword)
                          ->orWhere('description', $keyword);
                    }
                });

                // Check if exact match found, else perform broader search
                if (!$query->count()) {
                    $query->orWhere(function ($q) use ($keywords) {
                        foreach ($keywords as $keyword) {
                            $q->orWhere('tender_no', 'like', "%$keyword%")
                              ->orWhere('tender_number', 'like', "%$keyword%")
                              ->orWhere('description', 'like', "%$keyword%");
                        }
                    });
                }
>>>>>>> 398cfda8168c8c0dd008c8351ff486428ba935fc
            }
            $query->orderBy('posted_date', 'DESC');
        }
        
        $federal_tenders = $query->paginate($request->per_page); 
        return FederalTenderResource::collection($federal_tenders);
    }

<<<<<<< HEAD
=======

>>>>>>> 398cfda8168c8c0dd008c8351ff486428ba935fc
    public function paginateFederalTenders2(Request $request)
    {
        $request->validate([
            'order_by' => 'required',
            'per_page' => 'required|numeric'
        ]);
        $query = FederalTender::query();
        if($request->role == 'admin'){
            if ($request->status == 'All') {
                $query->whereDate('expiry_date', '>=', now()->toDateString())
                  ->orWhereDate('expiry_date', '<', now()->toDateString());
            } elseif ($request->status == 'Inactive') {
                $query->whereDate('expiry_date', '>=', now()->toDateString());
            } elseif ($request->status == 'Active') {
                $query->whereDate('expiry_date', '<', now()->toDateString());
            }

            if (!empty($request->search)) 
            {
                $searchQuery = $request->search . '*';  
                $query->whereRaw("MATCH(tender_no, title) AGAINST(? IN NATURAL LANGUAGE MODE)", [$searchQuery])
                    ->orderByRaw("MATCH(tender_no, title) AGAINST(? IN NATURAL LANGUAGE MODE) DESC, federal_tender_id DESC", [$searchQuery]);
            }

            if ($request->keyword == 'notice_name') {
                $query->join('federal_notices', 'federal_tenders.federal_notice_id', '=', 'federal_notices.federal_notice_id')
                        ->select('federal_tenders.*', 'federal_notices.notice_name') 
                      ->orderBy('federal_notices.notice_name', $request->order_by);
            } 
            if ($request->keyword == 'agency_name') {
                $query->join('federal_agencies', 'federal_tenders.federal_agency_id', '=', 'federal_agencies.federal_agency_id')
                        ->select('federal_tenders.*', 'federal_agencies.agency_name') 
                      ->orderBy('federal_agencies.agency_name', $request->order_by);
            } else {
                $query->orderBy($request->keyword, $request->order_by);
            }
        }else{
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
<<<<<<< HEAD

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
                if (is_string($request->keywords)) {
                    $keywords = array_map('trim', explode(',', $request->keywords));
                } else {
                    $keywords = array_map('trim', $request->keywords);
                }

                $searchQuery = implode(' ', $keywords);

                // Normalize the search query by removing hyphens
                $normalizedSearchQuery = str_replace('-', '', $searchQuery);

                // Start building the query
                $query->where(function ($subQuery) use ($normalizedSearchQuery, $searchQuery) {
                    // Normalize the tender_no field in the database and compare
                    $subQuery->whereRaw("REPLACE(tender_no, '-', '') = ?", [$normalizedSearchQuery])
                             ->orWhere('title', '=', $searchQuery);
                });

                // Use relevant matches only if there are no exact matches
                $query->orWhere(function ($subQuery) use ($normalizedSearchQuery, $keywords) {
                    $subQuery->whereRaw("NOT EXISTS (
                            SELECT 1 FROM federal_tenders 
                            WHERE REPLACE(tender_no, '-', '') = ?
                        )", [$normalizedSearchQuery])
                        ->whereRaw("MATCH(tender_no, title) AGAINST(? IN NATURAL LANGUAGE MODE)", [$normalizedSearchQuery]);

=======

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
                if (is_string($request->keywords)) {
                    $keywords = array_map('trim', explode(',', $request->keywords));
                } else {
                    $keywords = array_map('trim', $request->keywords);
                }

                $searchQuery = implode(' ', $keywords);

                // Normalize the search query by removing hyphens
                $normalizedSearchQuery = str_replace('-', '', $searchQuery);

                // Start building the query
                $query->where(function ($subQuery) use ($normalizedSearchQuery, $searchQuery) {
                    // Normalize the tender_no field in the database and compare
                    $subQuery->whereRaw("REPLACE(tender_no, '-', '') = ?", [$normalizedSearchQuery])
                             ->orWhere('title', '=', $searchQuery);
                });

                // Use relevant matches only if there are no exact matches
                $query->orWhere(function ($subQuery) use ($normalizedSearchQuery, $keywords) {
                    $subQuery->whereRaw("NOT EXISTS (
                            SELECT 1 FROM federal_tenders 
                            WHERE REPLACE(tender_no, '-', '') = ?
                        )", [$normalizedSearchQuery])
                        ->whereRaw("MATCH(tender_no, title) AGAINST(? IN NATURAL LANGUAGE MODE)", [$normalizedSearchQuery]);

>>>>>>> 398cfda8168c8c0dd008c8351ff486428ba935fc
                    // Fallback to LIKE for short keywords
                    foreach ($keywords as $keyword) {
                        if (strlen($keyword) < 4) {
                            $subQuery->orWhere('tender_no', 'LIKE', "%{$keyword}%")
                                     ->orWhere('title', 'LIKE', "%{$keyword}%");
                        }
                    }
                });

                // Order the results to prioritize exact matches
                $query->orderByRaw("
                    CASE 
                        WHEN REPLACE(tender_no, '-', '') = ? THEN 1
                        WHEN title = ? THEN 1
                        ELSE 2
                    END, 
                    MATCH(tender_no, title) AGAINST(? IN NATURAL LANGUAGE MODE) DESC,
                    federal_tender_id DESC
                ", [$normalizedSearchQuery, $searchQuery, $normalizedSearchQuery]);
            }
            $query->orderBy('federal_tender_id', 'DESC');
        }
    	
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
        return response()->json(['info' => 'No attachments found']);   
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
            'federal_notice_id' => 'required',
            'category_id' => 'nullable',
            'federal_agency_id' => 'required',
            'set_aside_id' => 'required',
            'naics_id' => 'required',
            'psc_id' => 'required',
            'contract_type_id' => 'nullable',
            'award_type_id' => 'nullable',
            'tender_url' => 'required',
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
            'opening_date' => 'required|date',
            'posted_date' => 'nullable',
            'expiry_date' => 'required|date|after:opening_date'
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
<<<<<<< HEAD
=======
            'title' => 'nullable',
>>>>>>> 398cfda8168c8c0dd008c8351ff486428ba935fc
            'country_id' => 'nullable',
            'state_id' => 'nullable',
            'tender_type_id' => 'nullable',
            'federal_notice_id' => 'nullable',
            'category_id' => 'nullable',
            'federal_agency_id' => 'nullable',
            'set_aside_id' => 'nullable',
            'naics_id' => 'nullable',
            'psc_id' => 'nullable',
            'contract_type_id' => 'nullable',
            'award_type_id' => 'nullable',
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
            'opening_date' => 'nullable|date',
            'posted_date' => 'nullable',
            'expiry_date' => 'nullable|date|after:opening_date'
        ]);

<<<<<<< HEAD

        $federal = FederalTender::where('federal_tender_id', $request->federal_tender_id)->first();
        if($federal){
            $tender_number = str_replace($request->tender_no, '-', '');
            $federal->update([
                'federal_tender_id' => $request->federal_tender_id,
                'tender_no' => $request->tender_no,
                'tender_number' => $tender_number,
                'title' => $request->title,
                'description' => $request->description,
                'country_id' => $request->country_id ? : null,
                'state_id' => $request->state_id ? : null,
                'tender_type_id' => $request->tender_type_id ? : null,
                'federal_notice_id' => $request->federal_notice_id ? : null,
                'category_id' => $request->category_id ? : null,
                'federal_agency_id' => $request->federal_agency_id ? : null,
                'set_aside_id' => $request->set_aside_id ? : null,
                'naics_id' => $request->naics_id ? : null,
                'psc_id' => $request->psc_id ? : null,
                'contract_type_id' => $request->cotract_type_id ? : null,
                'tender_url' => $request->tender_url ? : null,
                'fees' => $request->fees ? : null,
                'type_of_award' => $request->type_of_award ? : null,
                'place_of_performance' => $request->place_of_performance ? : null,
                'notice_id' => $request->country_id ? : null,
                'description_link' => $request->description_link ? : null,
                'category_name' => $request->category_name ? : null,
                'notice_name' => $request->notice_name ? : null,
                'agency_name' => $request->agency_name ? : null,
                'opening_date' => $request->opening_date ? : null,
                'posted_date' => $request->posted_date ? : null,
                'expiry_date' => $request->expiry_date ? : null

            ]);

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
=======
        if ($data['federal_notice_id'] === '') {
            $data['federal_notice_id'] = null;
        }
    
        if ($data['category_id'] === '') {
            $data['category_id'] = null; 
        }
    
        if ($data['federal_agency_id'] === '') {
            $data['federal_agency_id'] = null; 
        }    

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
>>>>>>> 398cfda8168c8c0dd008c8351ff486428ba935fc
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
            $update_federal_tender = FederalTender::where('federal_tender_id', $request->federal_tender_id)->update([
                'federal_notice_id' => $request->federal_notice_id,
                'federal_agency_id' => $request->federal_agency_id,
                'category_id' => $request->category_id,
                'state_id' => $request->state_id,
                'status' => true
            ]);
            if($update_federal_tender){
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

    public function getFederalTendersRange(Request $request){
        $data = $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'region' => 'required'
        ]);

        $federal_tenders = FederalTender::whereBetween('posted_date', [$request->from_date.' 00:00:00', $request->to_date,' 23:59:59'])->get();
        return FederalTenderResource::collection($federal_tenders);
    }

    public function deleteFederalTendersRange(Request $request){
        $data = $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'region' => 'required'
        ]);
<<<<<<< HEAD

        try {

            FederalAttachment::whereHas('FederalTender', function($que) use($request){
                $que->whereBetween('posted_date', [$request->from_date.' 00:00:00', $request->to_date,' 23:59:59']);
            })->delete();

            FederalContact::whereHas('StateTender', function($que) use($request){
                $que->whereBetween('posted_date', [$request->from_date.' 00:00:00', $request->to_date,' 23:59:59']);
            })->delete();

            FederalOfficeAddress::whereHas('StateTender', function($que) use($request){
                $que->whereBetween('posted_date', [$request->from_date.' 00:00:00', $request->to_date,' 23:59:59']);
            })->delete();

=======

        try {

            FederalAttachment::whereHas('FederalTender', function($que) use($request){
                $que->whereBetween('posted_date', [$request->from_date.' 00:00:00', $request->to_date,' 23:59:59']);
            })->delete();

            FederalContact::whereHas('StateTender', function($que) use($request){
                $que->whereBetween('posted_date', [$request->from_date.' 00:00:00', $request->to_date,' 23:59:59']);
            })->delete();

            FederalOfficeAddress::whereHas('StateTender', function($que) use($request){
                $que->whereBetween('posted_date', [$request->from_date.' 00:00:00', $request->to_date,' 23:59:59']);
            })->delete();

>>>>>>> 398cfda8168c8c0dd008c8351ff486428ba935fc
            $federal_tender = FederalTender::whereBetween('posted_date', [$request->from_date.' 00:00:00', $request->to_date,' 23:59:59'])->delete();
            return $federal_tender;
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to delete state tenders due to existing references in other tables.',
                'error' => $e->getMessage()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred.',
                'error' => $e->getMessage()
            ], 422);
        }
<<<<<<< HEAD
    }

    public function updateFederalApi(){
        Artisan::call('app:fetch-federal-data');
    }

    public function updateAttachments(){
        Artisan::call('app:update-federal-attachments');
    }

    public function updateDescription(){
        Artisan::call('app:update-federal-description');
    }

    public function downloadFederalTenders(Request $request){
        $data = $request->validate([
            'from_date' => 'required|date'
        ]);

        $api_key_res = ApiKey::first();
        if($api_key_res){
            $api_key = $api_key_res->api_key;
        }else{
            $api_key="8UPYOoBOM5C3ZSFpaxt1sIvZ3byn2Jfb91XoGyMT";
        }
        $posted_from = Carbon::createFromFormat('Y-m-d', $request->from_date)->format('m/d/Y');
        $posted_to = $posted_from;

        $url = "https://api.sam.gov/prod/opportunities/v2/search?limit=1&api_key={$api_key}&postedFrom={$posted_from}&postedTo={$posted_to}";
        // return $url;
        $response = Http::get($url);

        if ($response->successful()) {
            $data = $response->json();
            $total_records = $data['totalRecords'];
            $limit=1000;
            $last_offset=$total_records-($total_records%$limit); 
            $offset_array=[];
            for($offset=0; $offset<=$last_offset; $offset=$offset+$limit)
            {
                array_push($offset_array, $offset);         
            }

            foreach ($offset_array as $offset) 
            {
                $api_link_offset ='https://api.sam.gov/prod/opportunities/v2/search?limit='.$limit.'&offset='.$offset.'&api_key='.$api_key.'&postedFrom='.$posted_from.'&postedTo='.$posted_to;
                
                $response_data = Http::get($api_link_offset);
                if ($response_data->successful()) {
                    $federal_response = $response_data->json();
                    $chunks = array_chunk($federal_response['opportunitiesData'], 1);
                    foreach($chunks as $key => $chunk)
                    {
                         TenderProcess::dispatch($chunk, $api_key, $api_link_offset);
                    }
                }
            }
            Queue::after(function ($event) {
                $this->updateDescriptions();
                $this->info('Descriptions updated after queue processing.');
            });
            return response()->json(['message' => $total_records.' records fetched and queued for processing']);
            // $this->info('Opportunities fetched and queued for processing.');
        }else{
            return response()->json(['message' => 'Unable to fetch records'], 422);
        }
    }

=======
    }

    public function updateFederalApi(){
        Artisan::call('app:fetch-federal-data');
    }

    public function updateAttachments(){
        Artisan::call('app:update-federal-attachments');
    }

    public function updateDescription(){
        Artisan::call('app:update-federal-description');
    }

    public function downloadFederalTenders(Request $request){
        $data = $request->validate([
            'from_date' => 'required|date'
        ]);

        $api_key_res = ApiKey::first();
        if($api_key_res){
            $api_key = $api_key_res->api_key;
        }else{
            $api_key="8UPYOoBOM5C3ZSFpaxt1sIvZ3byn2Jfb91XoGyMT";
        }
        $posted_from = Carbon::createFromFormat('Y-m-d', $request->from_date)->format('m/d/Y');
        $posted_to = $posted_from;

        $url = "https://api.sam.gov/prod/opportunities/v2/search?limit=1&api_key={$api_key}&postedFrom={$posted_from}&postedTo={$posted_to}";
        // return $url;
        $response = Http::get($url);

        if ($response->successful()) {
            $data = $response->json();
            $total_records = $data['totalRecords'];
            $limit=1000;
            $last_offset=$total_records-($total_records%$limit); 
            $offset_array=[];
            for($offset=0; $offset<=$last_offset; $offset=$offset+$limit)
            {
                array_push($offset_array, $offset);         
            }

            foreach ($offset_array as $offset) 
            {
                $api_link_offset ='https://api.sam.gov/prod/opportunities/v2/search?limit='.$limit.'&offset='.$offset.'&api_key='.$api_key.'&postedFrom='.$posted_from.'&postedTo='.$posted_to;
                
                $response_data = Http::get($api_link_offset);
                if ($response_data->successful()) {
                    $federal_response = $response_data->json();
                    $chunks = array_chunk($federal_response['opportunitiesData'], 1);
                    foreach($chunks as $key => $chunk)
                    {
                         TenderProcess::dispatch($chunk, $api_key, $api_link_offset);
                    }
                }
            }
            Queue::after(function ($event) {
                $this->updateDescriptions();
                $this->info('Descriptions updated after queue processing.');
            });
            return response()->json(['message' => $total_records.' records fetched and queued for processing']);
            // $this->info('Opportunities fetched and queued for processing.');
        }else{
            return response()->json(['message' => 'Unable to fetch records'], 422);
        }
    }

>>>>>>> 398cfda8168c8c0dd008c8351ff486428ba935fc

}
