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
        $private_tenders = $query->paginate($request->per_page); 
        return InternationalTenderResource::collection($private_tenders);
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
}
