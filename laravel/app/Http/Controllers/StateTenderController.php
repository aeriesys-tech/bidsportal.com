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

class StateTenderController extends Controller
{
    public function paginateStateTenders(Request $request)
    {
    	$request->validate([
            'order_by' => 'required',
            'per_page' => 'required|numeric'
        ]);
    	$query = StateTender::query();
        $query->where('status', 1);
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


        $query->orderBy('state_tender_id', 'DESC');
        $state_tenders = $query->paginate($request->per_page); 
        return StateTenderResource::collection($state_tenders);
    }

    public function getStateTender(Request $request)
    {
        $state_tender = StateTender::where('state_tender_id', $request->state_tender_id)->first();
        return new StateTenderDetailResource($state_tender);
    }

    public function addStateTender(Request $request){

        $data = $request->validate([
            'tender_no' => 'required',
            'title' => 'required',
            'description' => 'required',
            'opening_date' => 'required',
            'expiry_date' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'tender_type_id' => 'nullable',
            'state_notice_id' => 'nullable',
            'category_id' => 'nullable',
            'state_agency_id' => 'nullable',
            'tender_url' => 'nullable',
            'fees' => 'nullable',
            'primary_address.title' => 'nullable|string|max:255',
        ]);
        $data['posted_date'] = date('Y-m-d H:i:s');
        $data['status'] = true;

        $state_tender = StateTender::create($data);

        if($state_tender){
            for($i=0; $i<count($request->attachments); $i++){
                $attachment = $request->attachments[$i];
                $attachment_name = $attachment->getClientOriginalName();
                $attachment_size = $attachment->getSize();
                $filePath = 'state/' . $attachment_name; 
                $result = Storage::disk('s3')->put($filePath, file_get_contents($attachment));
                if ($result) {
                    $attachment_url = Storage::disk('s3')->url($filePath);
                    if($attachment_url){
                        StateAttachment::updateOrCreate([
                            'state_tender_id' => $state_tender->state_tender_id,
                            'attachment_name' => $attachment_name,
                            'attachment_size' => $attachment_size,
                            'attachment_date' => date('Y-m-d'),
                            'attachment_url' => $attachment_url
                        ]);
                    }
                } else {
                    return response()->json([
                        'message' => 'File upload failed',
                    ], 500);
                }
            }
            return response()->json([
                'message' => 'State Tender added successfully',
            ]);
        }
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

    public function showS3BucketFiles(Request $request)
    {
        $data = $request->validate([
            'folder'=> 'required'
        ]);

        $folderPath = rtrim('State/attachments/'.$request->folder, '/') . '/';
        $files = Storage::disk('s3')->files($folderPath);
        $excel_files = array_map(function ($file) 
        {
            return pathinfo($file, PATHINFO_EXTENSION) === 'xlsx' ? basename($file) : null;
        }, $files);

        return array_values(array_filter($excel_files));
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
            $user = Auth::User();
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

}
