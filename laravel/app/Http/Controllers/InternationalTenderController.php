<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Storage;
use App\Imports\InternationalTenderImport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use ZipArchive;
use App\Models\InternationalTender;
use App\Models\InternationalAttachment;
use App\Jobs\UpdateInternationalFileSize;
use App\Http\Resources\InternationalTenderResource;
use App\Http\Resources\InternationalTenderDetailResource;
use App\Models\InternationalOfficeAddress;
use App\Models\InternationalContact;

class InternationalTenderController extends Controller
{
    public function paginateInternationalTenders(Request $request)
    {
        $request->validate([
            'order_by' => 'required',
            'per_page' => 'required|numeric'
        ]);
        $query = InternationalTender::query();
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

            $searchQuery = implode(' ', $keywords); // Join keywords for full-text search

            // Search for matches
            $query->whereRaw("MATCH(tender_no, title) AGAINST(? IN NATURAL LANGUAGE MODE)", [$searchQuery]);

            $query->orderByRaw("MATCH(tender_no, title) AGAINST(? IN NATURAL LANGUAGE MODE) DESC, international_tender_id DESC", [$searchQuery]);
        }

        if($request->search!='')
        {
            $query->where('tender_no', 'like', "%$request->search%")->orWhere('title', 'like', "%$request->search%")
            ->orWhere('opening_date', 'like', "%$request->search%")->orWhereHas('Category', function($que) use($request){
                $que->where('category_name', 'like', "%$request->search%");
            })->orwhereHas('State', function($qu) use($request){
                $qu->where('state_name', 'like', "%$request->search%");
            });
        }

        $query->orderBy('international_tender_id', 'DESC');
        $international_tenders = $query->paginate($request->per_page); 
        return InternationalTenderResource::collection($international_tenders);
    }
    public function updateInternationalBids(Request $request)
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
                            Excel::import(new InternationalTenderImport($folderPath, $request->folder), $file, 's3');
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
            $international_attachments = InternationalAttachment::whereNull('attachment_size')->where('attachment_date', $request->folder)->get();
            foreach ($international_attachments as $international_attachment) {
                UpdateInternationalFileSize::dispatch($international_attachment);
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

    public function paginateInactiveInternationalTenders(Request $request)
    {
        $request->validate([
            'order_by' => 'required',
            'per_page' => 'required|numeric'
        ]);
        $query = InternationalTender::query();
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

        if(!empty($request->international_notices)){
            $query->whereIn('international_notice_id', $request->international_notices);
        }

        if(!empty($request->states)){
            $query->whereIn('state_id', $request->states);
        }

        if(!empty($request->international_agencies)){
            $query->whereIn('international_agency_id', $request->international_agencies);
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

            $query->orderByRaw("MATCH(tender_no, title) AGAINST(? IN NATURAL LANGUAGE MODE) DESC, international_tender_id DESC", [$searchQuery]);
        }


        $query->orderBy('international_tender_id', 'DESC');
        $international_tenders = $query->paginate($request->per_page); 
        return InternationalTenderResource::collection($international_tenders);
    }

    public function addInternationalTender(Request $request)
    {
        $data = $request->validate([
            'tender_no' => 'required',
            'title' => 'required|unique:international_tenders,title',
            'description' => 'required',
            'opening_date' => 'required|date',
            'expiry_date' => 'required|date|after:opening_date',
            'country_id' => 'required',
            'state_id' => 'required',
            'tender_type_id' => 'nullable',
            'international_notice_id' => 'nullable',
            'category_id' => 'nullable',
            'international_agency_id' => 'nullable',
            'tender_url' => 'nullable',
            'fees' => 'nullable',
            'international_address_office.city' => 'nullable',
            'international_address_office.state' => 'nullable',
            'international_address_office.country' => 'nullable',
            'international_address_office.zip_code' => 'nullable',
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

        $international_tender = InternationalTender::create($data);

        if($request->international_office_address)
        {
            $address = json_decode($request->international_office_address, true);
            InternationalOfficeAddress::updateOrCreate([
                'international_tender_id' => $international_tender->international_tender_id,
                'city' => $address['city'],
                'state' => $address['state'],
                'country' => $address['country'],
                'zip_code' => $address['zip_code'] ?? null
            ]);
        }

        if ($request->primary_address) 
        {
            $primaryAddress = json_decode($request->primary_address, true);
            InternationalContact::updateOrCreate(
                [
                    'international_tender_id' => $international_tender->international_tender_id,
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
            InternationalContact::updateOrCreate(
                [
                    'international_tender_id' => $international_tender->international_tender_id,
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
                        InternationalAttachment::updateOrCreate(
                            [
                                'international_tender_id' => $international_tender->international_tender_id,
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


    public function updateInternationalTender(Request $request)
    {
        $request->validate([
            'international_tender_id' => 'required',
            'international_notice_id' => 'required',
            'category_id' => 'required',
            'state_id' => 'required'
        ]);

        try{
            $update_international_tender = InternationalTender::where('international_tender_id', $request->international_tender_id)->update([
                'international_notice_id' => $request->international_notice_id,
                'international_agency_id' => $request->international_agency_id,
                'category_id' => $request->category_id,
                'state_id' => $request->state_id,
                'status' => true
            ]);
            if($update_international_tender){
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

    public function updateTenderInternational(Request $request)
    {
        $data = $request->validate([
            'international_tender_id' => 'required|exists:international_tenders,international_tender_id',
            'tender_no' => 'required',
            'title' => 'required',
            'description' => 'required',
            'opening_date' => 'required|date',
            'expiry_date' => 'required|date|after:opening_date',
            'country_id' => 'required',
            'state_id' => 'required',
            'tender_type_id' => 'nullable',
            'international_notice_id' => 'nullable',
            'category_id' => 'nullable',
            'international_agency_id' => 'nullable',
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

        $international_tender = InternationalTender::where('international_tender_id', $request->international_tender_id)->first();
        $international_tender->update($data);

        if($request->international_office_address)
        {
            $address = json_decode($request->international_office_address, true);
            InternationalOfficeAddress::updateOrCreate([
                'international_tender_id' => $international_tender->international_tender_id
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
            InternationalContact::updateOrCreate(
                [
                    'international_tender_id' => $international_tender->international_tender_id,
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
            InternationalContact::updateOrCreate(
                [
                    'international_tender_id' => $international_tender->international_tender_id,
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
                        InternationalAttachment::updateOrCreate(
                            [
                                'international_tender_id' => $international_tender->international_tender_id,
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

    public function deleteInternationalTender(Request $request)
    {
        $request->validate([
            'international_tender_id' => 'required|exists:international_tenders,international_tender_id'
        ]);

        InternationalOfficeAddress::where('international_tender_id', $request->international_tender_id)->forceDelete();
        InternationalContact::where('international_tender_id', $request->international_tender_id)->forceDelete();
        InternationalAttachment::where('international_tender_id', $request->international_tender_id)->forceDelete();
        InternationalTender::where('international_tender_id', $request->international_tender_id)->forceDelete();
        return response()->json([
            "message" => "State Tender Deleted Successfully"
        ]);
    }

    public function getInternationalTender(Request $request)
    {
        $international_tender = InternationalTender::where('international_tender_id', $request->international_tender_id)->first();
        return new InternationalTenderDetailResource($international_tender);
    }
}