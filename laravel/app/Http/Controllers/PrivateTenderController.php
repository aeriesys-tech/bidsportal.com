<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Storage;
use App\Imports\PrivateTenderImport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use App\Jobs\UpdatePrivateFileSize;
use ZipArchive;
use App\Models\PrivateAttachment;
use App\Models\PrivateOfficeAddress;
use App\Models\PrivateContact;
use App\Models\User;
use App\Http\Resources\PrivateTenderResource;
use App\Http\Resources\PrivateTenderDetailResource;
use App\Models\PrivateTender;
use Illuminate\Support\Facades\Mail;
use App\Mail\PrivateTenderMail;
use Illuminate\Support\Facades\DB;

class PrivateTenderController extends Controller
{
    public function updatePrivateTenderNumber(){
        PrivateTender::whereNotNull('tender_no')->update([
            'tender_number' => DB::raw("REPLACE(tender_no, '-', '')")
        ]);
    }

    public function paginatePrivateTenders(Request $request)
    {
        $request->validate([
            'order_by' => 'required',
            'per_page' => 'required|numeric'
        ]);
        $query = PrivateTender::query();
        // $query->where('status', 1);

        if (isset($request->status)) {
            if ($request->status === 'All') {
            } elseif ($request->status === 'Active') {
                $query->where('status', true);
            } elseif ($request->status === 'Inactive') {
                $query->where('status', false);
            }
        }
        
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

        if(!empty($request->state_notices)){
            $query->whereIn('state_notice_id', $request->state_notices);
        }

        if(!empty($request->states)){
            $query->whereIn('state_id', $request->states);
        }

        if(!empty($request->state_agencies)){
            $query->whereIn('state_agency_id', $request->state_agencies);
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
                      ->orWhere('tender_number', $keyword);
                }
            });

            // Check if exact match found, else perform broader search
            if (!$query->count()) {
                $query->orWhere(function ($q) use ($keywords) {
                    foreach ($keywords as $keyword) {
                        $q->orWhere('tender_no', 'like', "%$keyword%")
                          ->orWhere('tender_number', 'like', "%$keyword%")
                          ->orWhere('title', 'like', "%$keyword%");
                    }
                });
            }
        }

        $query->orderBy('posted_date', 'DESC');
        $private_tenders = $query->paginate($request->per_page); 
        return PrivateTenderResource::collection($private_tenders);
    }

    public function getPrivateTenderbyTenderNo(Request $request)
    {
        $data = $request->validate([
            'tender_no' => 'required:exists,private_tenders'
        ]);
        $private_tender = PrivateTender::where('tender_no', $request->tender_no)->first();
        // return $private_tender;
        return new PrivateTenderDetailResource($private_tender);
    }

    public function paginatePrivateTenders1(Request $request)
    {
        $request->validate([
            'order_by' => 'required',
            'per_page' => 'required|numeric'
        ]);
        $query = PrivateTender::query();
        // $query->where('status', 1);

        if (isset($request->status)) {
            if ($request->status === 'All') {
            } elseif ($request->status === 'Active') {
                $query->where('status', true);
            } elseif ($request->status === 'Inactive') {
                $query->where('status', false);
            }
        }
        
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

        if(!empty($request->state_notices)){
            $query->whereIn('state_notice_id', $request->state_notices);
        }

        if(!empty($request->states)){
            $query->whereIn('state_id', $request->states);
        }

        if(!empty($request->state_agencies)){
            $query->whereIn('state_agency_id', $request->state_agencies);
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
                        SELECT 1 FROM private_tenders 
                        WHERE REPLACE(tender_no, '-', '') = ?
                    )", [$normalizedSearchQuery])
                    ->whereRaw("MATCH(tender_no, title) AGAINST(? IN NATURAL LANGUAGE MODE)", [$normalizedSearchQuery]);

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
                private_tender_id DESC
            ", [$normalizedSearchQuery, $searchQuery, $normalizedSearchQuery]);
        }

        $query->orderBy('private_tender_id', 'DESC');
        $private_tenders = $query->paginate($request->per_page); 
        return PrivateTenderResource::collection($private_tenders);
    }

    public function updatePrivateBids(Request $request)
    {     
        //Ensure the folder path ends with a '/'
        $folderPath = rtrim('State/attachments/'.$request->folder, '/') . '/';

        //Get files from S3
        $files = Storage::disk('s3')->files($folderPath);

        if (count($files) > 0) {
            foreach ($files as $key => $file) {
                // Check if the file has an .xlsx extension
                if (pathinfo($file, PATHINFO_EXTENSION) === 'xlsx') {
                    // Proceed only if the file exists in S3
                    if (Storage::disk('s3')->exists($file)) {
                        try {
                            // Import the file using Laravel Excel
                            Excel::import(new PrivateTenderImport($folderPath, $request->folder), $file, 's3');
                        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                            // Log the exception or handle it accordingly
                            return response()->json([
                                'message' => 'Error importing file: ' . $file,
                                'error' => $e->failures()
                            ], 500);
                        }
                    } else {
                        return response()->json([
                            'message' => 'File does not exist: ' . $file
                        ], 404);
                    }
                }
            }
            
            $today = Carbon::today();
            $private_attachments = PrivateAttachment::whereNull('attachment_size')->where('attachment_date', $request->folder)->get();
            foreach ($private_attachments as $private_attachment) {
                UpdatePrivateFileSize::dispatch($private_attachment);
            }

            return response()->json([
                'message' => 'Data imported successfully'
            ]);
        } else {
            return response()->json([
                'message' => 'No records found'
            ], 422);
        }
    }

    public function paginateInactivePrivateTenders(Request $request)
    {
        $request->validate([
            'order_by' => 'required',
            'per_page' => 'required|numeric'
        ]);
        $query = PrivateTender::query();
        $query->where('status', 0);
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

        if(!empty($request->private_notices)){
            $query->whereIn('private_notice_id', $request->private_notices);
        }

        if(!empty($request->states)){
            $query->whereIn('state_id', $request->states);
        }

        if(!empty($request->private_agencies)){
            $query->whereIn('private_agency_id', $request->private_agencies);
        }

        if (!empty($request->keywords)) {
            if (is_string($request->keywords)) {
                $keywords = array_map('trim', explode(',', $request->keywords));
            } else {
                $keywords = array_map('trim', $request->keywords);
            }

            $searchQuery = implode(' ', $keywords); // Join keywords for full-text search

            // Search for matches
            $query->whereRaw("MATCH(tender_no, title) AGAINST(? IN NATURAL LANGUAGE MODE)", [$searchQuery]);

            $query->orderByRaw("MATCH(tender_no, title) AGAINST(? IN NATURAL LANGUAGE MODE) DESC, private_tender_id DESC", [$searchQuery]);
        }

        if (!empty($request->search)) 
        {
            $searchQuery = $request->search . '*';  
            $query->whereRaw("MATCH(tender_no, title) AGAINST(? IN NATURAL LANGUAGE MODE)", [$searchQuery])
                ->orderByRaw("MATCH(tender_no, title) AGAINST(? IN NATURAL LANGUAGE MODE) DESC, private_tender_id DESC", [$searchQuery]);
        }

        $query->orderBy($request->keyword, $request->order_by);
        $private_tenders = $query->paginate($request->per_page); 
        return PrivateTenderResource::collection($private_tenders);
    }

    public function addPrivateTender(Request $request)
    {
        $data = $request->validate([
            'tender_no' => 'required',
            'title' => 'required|unique:private_tenders,title',
            'description' => 'required',
            'opening_date' => 'required|date',
            'expiry_date' => 'required|date|after:opening_date',
            'country_id' => 'required',
            'state_id' => 'required',
            'tender_type_id' => 'nullable',
            'private_notice_id' => 'nullable',
            'category_id' => 'nullable',
            'private_agency_id' => 'nullable',
            'tender_url' => 'nullable',
            'fees' => 'nullable',
            'private_address_office.city' => 'nullable',
            'private_address_office.state' => 'nullable',
            'private_address_office.country' => 'nullable',
            'private_address_office.zip_code' => 'nullable',
            'primary_address.title' => 'nullable|string|max:255',
            'primary_address.email' => 'nullable|email',
            'primary_address.phone' => 'nullable',
            'primary_address.full_name' => 'nullable',
            'secondary_address.email' => 'nullable|email',
            'secondary_address.phone' => 'nullable',
            'secondary_address.title' => 'nullable|string|max:255',
            'secondary_address.full_name' => 'nullable'
        ]);
        $data['posted_date'] = date('Y-m-d H:i:s');
        $data['status'] = false;

        $private_tender = PrivateTender::create($data);

        if($request->private_office_address)
        {
            $address = json_decode($request->private_office_address, true);
            PrivateOfficeAddress::updateOrCreate([
                'private_tender_id' => $private_tender->private_tender_id,
                'city' => $address['city'],
                'state' => $address['state'],
                'country' => $address['country'],
                'zip_code' => $address['zip_code'] ?? null
            ]);
        }

        if ($request->primary_address) 
        {
            $primaryAddress = json_decode($request->primary_address, true);
            PrivateContact::updateOrCreate(
                [
                    'private_tender_id' => $private_tender->private_tender_id,
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
            PrivateContact::updateOrCreate(
                [
                    'private_tender_id' => $private_tender->private_tender_id,
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
                $filePath = 'state/' . $attachment_name; 
                $result = Storage::disk('s3')->put($filePath, file_get_contents($attachment));
        
                if ($result) {
                    $attachment_url = Storage::disk('s3')->url($filePath);
                    if ($attachment_url) {
                        PrivateAttachment::updateOrCreate(
                            [
                                'private_tender_id' => $private_tender->private_tender_id,
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
            'message' => 'State Tender added successfully',
        ]);
    }


    public function updatePrivateTender(Request $request)
    {
        $request->validate([
            'private_tender_id' => 'required',
            'private_notice_id' => 'required',
            'category_id' => 'required',
            'state_id' => 'required'
        ]);

        try{
            $update_private_tender = PrivateTender::where('private_tender_id', $request->private_tender_id)->update([
                'private_notice_id' => $request->private_notice_id,
                'private_agency_id' => $request->private_agency_id,
                'category_id' => $request->category_id,
                'state_id' => $request->state_id,
                'status' => true
            ]);
            if($update_private_tender){
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

    public function updateTenderPrivate(Request $request)
    {
        $data = $request->validate([
            'private_tender_id' => 'required|exists:private_tenders,private_tender_id',
            'tender_no' => 'required',
            'title' => 'required',
            'description' => 'required',
            'opening_date' => 'required|date',
            'expiry_date' => 'required|date|after:opening_date',
            'country_id' => 'required',
            'state_id' => 'required',
            'tender_type_id' => 'nullable',
            'private_notice_id' => 'nullable',
            'category_id' => 'nullable',
            'private_agency_id' => 'nullable',
            'tender_url' => 'nullable',
            'primary_address.title' => 'nullable|string|max:255',
            'primary_address.email' => 'nullable',
            'primary_address.phone' => 'nullable',
            'primary_address.full_name' => 'nullable',
            'secondary_address.email' => 'nullable',
            'secondary_address.phone' => 'nullable',
            'secondary_address.title' => 'nullable|string|max:255',
            'secondary_address.full_name' => 'nullable'
        ]);
        $data['fees'] = isset($request->fees) ? (is_numeric($request->fees) ? $request->fees : 0) : null;
        $data['posted_date'] = date('Y-m-d H:i:s');

        $private_tender = PrivateTender::where('private_tender_id', $request->private_tender_id)->first();
        $private_tender->update($data);

        if($request->private_office_address)
        {
            $address = json_decode($request->private_office_address, true);
            PrivateOfficeAddress::updateOrCreate([
                'private_tender_id' => $private_tender->private_tender_id
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
            PrivateContact::updateOrCreate(
                [
                    'private_tender_id' => $private_tender->private_tender_id,
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
            PrivateContact::updateOrCreate(
                [
                    'private_tender_id' => $private_tender->private_tender_id,
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
                $filePath = 'state/' . $attachment_name; 
                $result = Storage::disk('s3')->put($filePath, file_get_contents($attachment));
    
                if ($result) {
                    $attachment_url = Storage::disk('s3')->url($filePath);
                    if ($attachment_url) {
                        PrivateAttachment::updateOrCreate(
                            [
                                'private_tender_id' => $private_tender->private_tender_id,
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
            'message' => 'State Tender updated successfully',
        ]);
    }

    public function deletePrivateTender(Request $request)
    {
        $request->validate([
            'private_tender_id' => 'required|exists:private_tenders,private_tender_id'
        ]);

        PrivateOfficeAddress::where('private_tender_id', $request->private_tender_id)->forceDelete();
        PrivateContact::where('private_tender_id', $request->private_tender_id)->forceDelete();
        PrivateAttachment::where('private_tender_id', $request->private_tender_id)->forceDelete();
        PrivateTender::where('private_tender_id', $request->private_tender_id)->forceDelete();
        return response()->json([
            "message" => "State Tender Deleted Successfully"
        ]);
    }

    public function getPrivateTender(Request $request)
    {
        $private_tender = PrivateTender::where('private_tender_id', $request->private_tender_id)->first();
        return new PrivateTenderDetailResource($private_tender);
    }

    public function sendPrivateTenderMail(Request $request)
    {
        $data = $request->validate([
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
            'private_tenders' => 'required|array'
        ]);

        if(isset($request->private_tenders) && !empty($request->private_tenders)){
            $bids = PrivateTender::whereIn('private_tender_id', $request->private_tenders)->get();
            $user = User::where('user_id', $request->user_id)->first();
            $emails = array_map('trim', explode(',', $request->recipient_email));
            Mail::to($emails)->send(new PrivateTenderMail($bids, $user, $request));

            return response()->json(['status' => 'Email sent successfully!']);
        }else{
            return response()->json(['status' => 'Error sending mail'], 422);
        }
    }
}
