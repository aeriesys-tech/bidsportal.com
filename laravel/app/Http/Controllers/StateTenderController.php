<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\StateTender;
use App\Models\User;
use App\Models\StateAttachment;
use App\Models\StateOfficeAddress;
use App\Http\Resources\StateTenderResource;
use App\Http\Resources\StateTenderDetailResource;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\StateTenderMail;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StateTenderImport;
use App\Jobs\UpdateFileSize;
use ZipArchive;
use Auth;
use App\Models\StateContact;

class StateTenderController extends Controller
{
    public function paginateStateTenders(Request $request)
    {
        $request->validate([
            'order_by' => 'required',
            'per_page' => 'required|numeric'
        ]);
        $query = StateTender::query();
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

            // Start building the query
            $query->where(function ($subQuery) use ($searchQuery) {
                // Check for exact match in title or tender_no
                $subQuery->where('title', '=', $searchQuery)
                         ->orWhere('tender_no', '=', $searchQuery);
            });

            // Use relevant matches only if there are no exact matches
            $query->orWhere(function ($subQuery) use ($searchQuery, $keywords) {
                $subQuery->whereRaw("NOT EXISTS (
                    SELECT 1 FROM federal_tenders 
                    WHERE title = ? OR tender_no = ?
                )", [$searchQuery, $searchQuery])
                ->whereRaw("MATCH(tender_no, title) AGAINST(? IN NATURAL LANGUAGE MODE)", [$searchQuery]);

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
                    WHEN title = ? THEN 1
                    WHEN tender_no = ? THEN 1
                    ELSE 2
                END, 
                MATCH(tender_no, title) AGAINST(? IN NATURAL LANGUAGE MODE) DESC,
                state_tender_id DESC
            ", [$searchQuery, $searchQuery, $searchQuery]);
        }

        $query->orderBy('state_tender_id', 'DESC');
        $state_tenders = $query->paginate($request->per_page); 
        return StateTenderResource::collection($state_tenders);
    }

    public function paginateInactiveStateTenders(Request $request)
    {
        $request->validate([
            'order_by' => 'required',
            'per_page' => 'required|numeric'
        ]);
        $query = StateTender::query();
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

            $searchQuery = implode(' ', $keywords); // Join keywords for full-text search

            // Search for matches
            $query->whereRaw("MATCH(tender_no, title) AGAINST(? IN NATURAL LANGUAGE MODE)", [$searchQuery]);

            $query->orderByRaw("MATCH(tender_no, title) AGAINST(? IN NATURAL LANGUAGE MODE) DESC, state_tender_id DESC", [$searchQuery]);
        }

        if (!empty($request->search)) 
        {
            $searchQuery = $request->search . '*';  
            $query->whereRaw("MATCH(tender_no, title) AGAINST(? IN NATURAL LANGUAGE MODE)", [$searchQuery])
                ->orderByRaw("MATCH(tender_no, title) AGAINST(? IN NATURAL LANGUAGE MODE) DESC, state_tender_id DESC", [$searchQuery]);
        }

        $query->orderBy($request->keyword,$request->order_by);
        $state_tenders = $query->paginate($request->per_page); 
        return StateTenderResource::collection($state_tenders);
    }

    public function getStateTender(Request $request)
    {
        $state_tender = StateTender::where('state_tender_id', $request->state_tender_id)->first();
        return new StateTenderDetailResource($state_tender);
    }

    public function addStateTender(Request $request)
    {
        $data = $request->validate([
            'tender_no' => 'required',
            'title' => 'required|unique:state_tenders,title',
            'description' => 'required',
            'opening_date' => 'required|date',
            'expiry_date' => 'required|date|after:opening_date',
            'country_id' => 'required',
            'state_id' => 'required',
            'tender_type_id' => 'nullable',
            'state_notice_id' => 'nullable',
            'category_id' => 'nullable',
            'state_agency_id' => 'nullable',
            'tender_url' => 'nullable',
            'fees' => 'nullable',
            'state_address_office.city' => 'nullable',
            'state_address_office.state' => 'nullable',
            'state_address_office.country' => 'nullable',
            'state_address_office.zip_code' => 'nullable',
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
        $data['status'] = true;

        $state_tender = StateTender::create($data);

        if($request->state_office_address)
        {
            $address = json_decode($request->state_office_address, true);
            StateOfficeAddress::updateOrCreate([
                'state_tender_id' => $state_tender->state_tender_id,
                'city' => $address['city'],
                'state' => $address['state'],
                'country' => $address['country'],
                'zip_code' => $address['zip_code'] ?? null
            ]);
        }

        if ($request->primary_address) 
        {
            $primaryAddress = json_decode($request->primary_address, true);
            StateContact::updateOrCreate(
                [
                    'state_tender_id' => $state_tender->state_tender_id,
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
            StateContact::updateOrCreate(
                [
                    'state_tender_id' => $state_tender->state_tender_id,
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
                        StateAttachment::updateOrCreate(
                            [
                                'state_tender_id' => $state_tender->state_tender_id,
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

    public function updateStateBids(Request $request)
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
                            Excel::import(new StateTenderImport($folderPath, $request->folder), $file, 's3');
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
            $state_attachments = StateAttachment::whereNull('attachment_size')->where('attachment_date', $request->folder)->get();
            foreach ($state_attachments as $state_attachment) {
                UpdateFileSize::dispatch($state_attachment);
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

    public function updateStateTender(Request $request)
    {
        $request->validate([
            'state_tender_id' => 'required',
            'state_notice_id' => 'required',
            'category_id' => 'required',
            'state_id' => 'required'
        ]);

        try{
            $update_state_tender = StateTender::where('state_tender_id', $request->state_tender_id)->update([
                'state_notice_id' => $request->state_notice_id,
                'state_agency_id' => $request->state_agency_id,
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

    public function deleteStateTenders(Request $request){
        StateOfficeAddress::whereIn('state_tender_id', $request->delete_tenders)->delete();
        StateAttachment::whereIn('state_tender_id', $request->delete_tenders)->delete();
        return StateTender::whereIn('state_tender_id', $request->delete_tenders)->delete();
    }

    public function sendStateTenderMail(Request $request)
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
            'state_tenders' => 'required|array'
        ]);

        if(isset($request->state_tenders) && !empty($request->state_tenders)){
            $bids = StateTender::whereIn('state_tender_id', $request->state_tenders)->get();
            $user = User::where('user_id', $request->user_id)->first();
            $emails = array_map('trim', explode(',', $request->recipient_email));
            Mail::to($emails)->send(new StateTenderMail($bids, $user, $request));

            return response()->json(['status' => 'Email sent successfully!']);
        }else{
            return response()->json(['status' => 'Error sending mail'], 422);
        }
    }

    public function downloadStateAttachments($state_tender_id)
    {
        $state_attachments = StateAttachment::where('state_tender_id', $state_tender_id)->get();
        if(count($state_attachments)){
            
            $zip_file_name = 'attachments.zip';
            $temp_zip_path = storage_path($zip_file_name);
            $zip = new ZipArchive;
            if ($zip->open($temp_zip_path, ZipArchive::CREATE) === TRUE) {
                foreach ($state_attachments as $state_attachment) {
                    $file_contents = file_get_contents($state_attachment->attachment_url); 
                    $file_name = basename($state_attachment->attachment_url); 
                    $zip->addFromString($file_name, $file_contents);
                }
                $zip->close();
            } else {
                return response()->json(['error' => 'Failed to create ZIP file'], 500);
            }
            return response()->download($temp_zip_path, $zip_file_name)->deleteFileAfterSend(true);
        }
    }

    public function updateTenderState(Request $request)
    {
        $data = $request->validate([
            'state_tender_id' => 'required|exists:state_tenders,state_tender_id',
            'tender_no' => 'required',
            'title' => 'required',
            'description' => 'required',
            'opening_date' => 'required|date',
            'expiry_date' => 'required|date|after:opening_date',
            'country_id' => 'required',
            'state_id' => 'required',
            'tender_type_id' => 'nullable',
            'state_notice_id' => 'nullable',
            'category_id' => 'nullable',
            'state_agency_id' => 'nullable',
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
        $data['status'] = true;

        $state_tender = StateTender::where('state_tender_id', $request->state_tender_id)->first();
        $state_tender->update($data);

        if($request->state_office_address)
        {
            $address = json_decode($request->state_office_address, true);
            StateOfficeAddress::updateOrCreate([
                'state_tender_id' => $state_tender->state_tender_id
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
            StateContact::updateOrCreate(
                [
                    'state_tender_id' => $state_tender->state_tender_id,
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
            StateContact::updateOrCreate(
                [
                    'state_tender_id' => $state_tender->state_tender_id,
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
                        StateAttachment::updateOrCreate(
                            [
                                'state_tender_id' => $state_tender->state_tender_id,
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

    public function deleteStateTender(Request $request)
    {
        $request->validate([
            'state_tender_id' => 'required|exists:state_tenders,state_tender_id'
        ]);

        StateOfficeAddress::where('state_tender_id', $request->state_tender_id)->forceDelete();
        StateContact::where('state_tender_id', $request->state_tender_id)->forceDelete();
        StateAttachment::where('state_tender_id', $request->state_tender_id)->forceDelete();
        StateTender::where('state_tender_id', $request->state_tender_id)->forceDelete();
        return response()->json([
            "message" => "State Tender Deleted Successfully"
        ]);
    }
}
