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
use App\Imports\demoimport;
use App\Jobs\UpdateFileSize;
use ZipArchive;
use Auth;
use App\Models\StateContact;
use Illuminate\Support\Facades\DB;

class StateTenderController extends Controller
{
    public function paginateStateTenders(Request $request)
    {
        $request->validate([
            'order_by' => 'required',
            'per_page' => 'required|numeric'
        ]);
        $query = StateTender::query();
    
        if($request->role == 'admin'){
            if($request->status == 'All'){
                $query->whereIn('status', [0, 1]);
            } else if ($request->status == 'Inactive') {
                $query->where('status', 0);
            } elseif ($request->status == 'Active') {
                $query->where('status', 1);
            } elseif ($request->status == 'Today') {
                $query->whereBetween('posted_date', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')]);
            }

            if (!empty($request->search)) 
            {
                $query->where('tender_no', 'like', '%'.$request->search.'%');
                // $searchQuery = $request->search . '*';  
                // $query->whereRaw("MATCH(tender_no, title) AGAINST(? IN NATURAL LANGUAGE MODE)", [$searchQuery])
                //     ->orderByRaw("MATCH(tender_no, title) AGAINST(? IN NATURAL LANGUAGE MODE) DESC, state_tender_id DESC", [$searchQuery]);
            }

            if ($request->keyword == 'notice_name') {
                $query->join('state_notices', 'state_tenders.state_notice_id', '=', 'state_notices.state_notice_id')
                        ->select('state_tenders.*', 'state_notices.notice_name') 
                      ->orderBy('state_notices.notice_name', $request->order_by);
            } 
            if ($request->keyword == 'agency_name') {
                $query->join('state_agencies', 'state_tenders.state_agency_id', '=', 'state_agencies.state_agency_id')
                        ->select('state_tenders.*', 'state_agencies.agency_name') 
                      ->orderBy('state_agencies.agency_name', $request->order_by);
            } else {
                $query->orderBy($request->keyword, $request->order_by);
            }
        } else {

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
            }

            $query->orderBy('state_tender_id', 'DESC');
        }
        $state_tenders = $query->paginate($request->per_page); 
        return StateTenderResource::collection($state_tenders);
    }

    public function getStateTenderbyTenderNo(Request $request)
    {
        $data = $request->validate([
            'tender_no' => 'required:exists,state_tenders'
        ]);
        $state_tender = StateTender::where('tender_no', $request->tender_no)->first();
        return new StateTenderDetailResource($state_tender);
    }

    public function paginateStateTenders2(Request $request)
    {
        $request->validate([
            'order_by' => 'required',
            'per_page' => 'required|numeric'
        ]);
        $query = StateTender::query();
    
        if($request->role == 'admin'){
            if($request->status == 'All'){
                $query->whereIn('status', [0, 1]);
            } else if ($request->status == 'Inactive') {
                $query->where('status', 0);
            } elseif ($request->status == 'Active') {
                $query->where('status', 1);
            } elseif ($request->status == 'Today') {
                $query->whereBetween('posted_date', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')]);
            }

            if (!empty($request->search)) 
            {
                $query->where('tender_no', 'like', '%'.$request->search.'%');
                // $searchQuery = $request->search . '*';  
                // $query->whereRaw("MATCH(tender_no, title) AGAINST(? IN NATURAL LANGUAGE MODE)", [$searchQuery])
                //     ->orderByRaw("MATCH(tender_no, title) AGAINST(? IN NATURAL LANGUAGE MODE) DESC, state_tender_id DESC", [$searchQuery]);
            }

            if ($request->keyword == 'notice_name') {
                $query->join('state_notices', 'state_tenders.state_notice_id', '=', 'state_notices.state_notice_id')
                        ->select('state_tenders.*', 'state_notices.notice_name') 
                      ->orderBy('state_notices.notice_name', $request->order_by);
            } 
            if ($request->keyword == 'agency_name') {
                $query->join('state_agencies', 'state_tenders.state_agency_id', '=', 'state_agencies.state_agency_id')
                        ->select('state_tenders.*', 'state_agencies.agency_name') 
                      ->orderBy('state_agencies.agency_name', $request->order_by);
            } else {
                $query->orderBy($request->keyword, $request->order_by);
            }
        } else {

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

            // if (!empty($request->keywords)) {
            //     if (is_string($request->keywords)) {
            //         $keywords = array_map('trim', explode(',', $request->keywords));
            //     } else {
            //         $keywords = array_map('trim', $request->keywords);
            //     }

            //     $searchQuery = implode(' ', $keywords);

            //     // Start building the query
            //     $query->where(function ($subQuery) use ($searchQuery) {
            //         // Check for exact match in title or tender_no
            //         $subQuery->where('title', '=', $searchQuery)
            //                  ->orWhere('tender_no', '=', $searchQuery);
            //     });

            //     // Use relevant matches only if there are no exact matches
            //     $query->orWhere(function ($subQuery) use ($searchQuery, $keywords) {
            //         $subQuery->whereRaw("NOT EXISTS (
            //             SELECT 1 FROM state_tenders 
            //             WHERE title = ? OR tender_no = ?
            //         )", [$searchQuery, $searchQuery])
            //         ->whereRaw("MATCH(tender_no, title) AGAINST(? IN NATURAL LANGUAGE MODE)", [$searchQuery]);

            //         // Fallback to LIKE for short keywords
            //         foreach ($keywords as $keyword) {
            //             if (strlen($keyword) < 4) {
            //                 $subQuery->orWhere('tender_no', 'LIKE', "%{$keyword}%")
            //                          ->orWhere('title', 'LIKE', "%{$keyword}%");
            //             }
            //         }
            //     });

            //     // Order the results to prioritize exact matches
            //     $query->orderByRaw("
            //         CASE 
            //             WHEN title = ? THEN 1
            //             WHEN tender_no = ? THEN 1
            //             ELSE 2
            //         END, 
            //         MATCH(tender_no, title) AGAINST(? IN NATURAL LANGUAGE MODE) DESC,
            //         state_tender_id DESC
            //     ", [$searchQuery, $searchQuery, $searchQuery]);
            // }
            if (!empty($request->keywords)) {
                if (is_string($request->keywords)) {
                    $keywords = array_map('trim', explode(',', $request->keywords));
                } else {
                    $keywords = array_map('trim', $request->keywords);
                }

                $searchQuery = implode(' ', $keywords);
                $normalizedSearchQuery = str_replace('-', '', $searchQuery); // Remove hyphens from input

                $query->where(function ($subQuery) use ($searchQuery, $normalizedSearchQuery, $keywords) {
                    $subQuery->whereRaw("REPLACE(tender_no, '-', '') = ?", [$normalizedSearchQuery])
                             ->orWhereRaw("REPLACE(title, '-', '') = ?", [$normalizedSearchQuery]);

                    // Use relevant matches only if there are no exact matches
                    $subQuery->orWhereRaw("MATCH(tender_no, title) AGAINST(? IN NATURAL LANGUAGE MODE)", [$searchQuery]);

                    // Fallback to LIKE for short keywords
                    foreach ($keywords as $keyword) {
                        $normalizedKeyword = str_replace('-', '', $keyword);
                        if (strlen($normalizedKeyword) < 4) {
                            $subQuery->orWhereRaw("REPLACE(tender_no, '-', '') LIKE ?", ["%{$normalizedKeyword}%"])
                                     ->orWhereRaw("REPLACE(title, '-', '') LIKE ?", ["%{$normalizedKeyword}%"]);
                        }
                    }
                });

                // Order the results to prioritize exact matches
                $query->orderByRaw("
                    CASE 
                        WHEN REPLACE(title, '-', '') = ? THEN 1
                        WHEN REPLACE(tender_no, '-', '') = ? THEN 1
                        ELSE 2
                    END, 
                    MATCH(tender_no, title) AGAINST(? IN NATURAL LANGUAGE MODE) DESC,
                    state_tender_id DESC
                ", [$normalizedSearchQuery, $normalizedSearchQuery, $searchQuery]);
            }


            $query->orderBy('state_tender_id', 'DESC');
        }
        $state_tenders = $query->paginate($request->per_page); 
        return StateTenderResource::collection($state_tenders);
    }

    public function updateStateTenderNumber(){
        StateTender::whereNotNull('tender_no')->update([
            'tender_number' => DB::raw("REPLACE(tender_no, '-', '')")
        ]);
    }

    public function getTotalCount(){
        $counts = StateTender::selectRaw("
            COUNT(*) as total_bids,
            SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as active_bids,
            SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) as inactive_bids
        ")->first();

        $auto_approved_today = StateTender::where('status', 1)->where('upload_type', 'like', 'auto')
            ->whereBetween('posted_date', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])
            ->count();

        $manual_approved_today = StateTender::where('status', 1)->where('upload_type', 'like', 'manual')
            ->whereBetween('posted_date', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])
            ->count();

        return response()->json([
            'total_bids' => $counts->total_bids,
            'active' => $counts->active_bids,
            'pending' => $counts->inactive_bids,
            'auto_approved_today' => $auto_approved_today,
            'manual_approved_today' => $manual_approved_today
        ]);
    }

    public function paginateStateTenders1(Request $request)
    {
        $request->validate([
            'order_by' => 'required',
            'per_page' => 'required|numeric'
        ]);
        $query = StateTender::query();

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
                        SELECT 1 FROM state_tenders 
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
                state_tender_id DESC
            ", [$normalizedSearchQuery, $searchQuery, $normalizedSearchQuery]);
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
            'state_notice_id' => 'required',
            'category_id' => 'required',
            'state_agency_id' => 'required',
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
        $data['tender_number'] = str_replace($data['tender_no'], '-', '');
        $data['upload_type'] = 'manual';

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

    // public function updateStateBids(Request $request)
    // {     
    //     //Ensure the folder path ends with a '/'
    //     $folderPath = rtrim('State/attachments/'.$request->folder, '/') . '/';

    //     //Get files from S3
    //     $files = Storage::disk('s3')->files($folderPath);

    //     if (count($files) > 0) {
    //         foreach ($files as $key => $file) {
    //             // Check if the file has an .xlsx extension
    //             if (pathinfo($file, PATHINFO_EXTENSION) === 'xlsx') {
    //                 // Proceed only if the file exists in S3
    //                 if (Storage::disk('s3')->exists($file)) {
    //                     try {
    //                         // Import the file using Laravel Excel
    //                         Excel::import(new StateTenderImport($folderPath, $request->folder), $file, 's3');
    //                     } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
    //                         // Log the exception or handle it accordingly
    //                         return response()->json([
    //                             'message' => 'Error importing file: ' . $file,
    //                             'error' => $e->failures()
    //                         ], 500);
    //                     }
    //                 } else {
    //                     return response()->json([
    //                         'message' => 'File does not exist: ' . $file
    //                     ], 404);
    //                 }
    //             }
    //         }

    //         return response()->json([
    //             'message' => 'Data imported successfully'
    //         ]);
    //     } else {
    //         return response()->json([
    //             'message' => 'Folder does not exist or is empty',
    //             'error' => []
    //         ], 422);
    //     }
    // }

    public function updateStateBids(Request $request)
    {     
        // Ensure the folder path ends with a '/'
        $folderPath = rtrim('State/attachments/'.$request->folder, '/') . '/';

        // Get files from S3
        $files = Storage::disk('s3')->files($folderPath);

        if (count($files) > 0) {
            $errors = [];
            foreach ($files as $key => $file) {
                // Check if the file has an .xlsx extension
                if (pathinfo($file, PATHINFO_EXTENSION) === 'xlsx') {
                    // Proceed only if the file exists in S3
                    if (Storage::disk('s3')->exists($file)) {
                        try {
                            // Import the file using Laravel Excel
                            $import = new StateTenderImport($folderPath, $request->folder);
                            Excel::import($import, $file, 's3');

                            // Check if the imported row count meets the required condition
                            // if ($import->getRowCount() < 1) {
                            //     $errors[] = "File {$file} did not meet row count condition.";
                            //     continue; // Continue with the next file
                            // }
                        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                            $errors[] = "Error importing file: {$file} - " . json_encode($e->failures());
                            continue; // Continue with the next file
                        }
                    } else {
                        $errors[] = "File does not exist: {$file}";
                        continue; // Continue with the next file
                    }
                }
            }

            // If there are errors, return them
            if (!empty($errors)) {
                return response()->json([
                    'message' => 'Some files encountered issues during import',
                    'errors'  => $errors
                ], 422);
            }

            return response()->json([
                'message' => 'All valid files imported successfully'
            ]);
        } else {
            return response()->json([
                'message' => 'Folder does not exist or is empty',
                'error' => []
            ], 422);
        }
    }



    public function updateStateBidsManual(Request $request)
    {     
        //Ensure the folder path ends with a '/'
        $file_name = public_path().'/attachments/14_NorthCarolina_VendorPortal_eVP.xlsx';
        $files = [$file_name];
        // dd($files);

        $folderPath = rtrim('State/attachments/'.$request->folder, '/') . '/';
        $folder = '';

        if (count($files) > 0) {
            foreach ($files as $key => $file) {
                // Check if the file has an .xlsx extension
                if (pathinfo($file, PATHINFO_EXTENSION) === 'xlsx') {
                     Excel::import(new StateTenderImport($folderPath, $folder), $file);
                }
            }
            
            // $today = Carbon::today();
            // $state_attachments = StateAttachment::whereNull('attachment_size')->where('attachment_date', $request->folder)->get();
            // foreach ($state_attachments as $state_attachment) {
            //     UpdateFileSize::dispatch($state_attachment);
            // }

            return response()->json([
                'message' => 'Data imported successfully'
            ]);
        } else {
            return response()->json([
                'message' => 'No records found'
            ], 422);
        }
    }

    public function updateQuery(){
        DB::statement('ALTER TABLE `state_tenders` CHANGE `description` `description` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL');
        DB::statement('ALTER TABLE `state_tenders` CHANGE `opening_date` `opening_date` DATE NULL');
    }

    public function updateStateTender(Request $request)
    {
        $request->validate([
            'posted_date' => 'required',
            'opening_date' => 'required',
            'expiry_date' => 'required',
            'state_tender_id' => 'required',
            'state_notice_id' => 'required',
            'category_id' => 'required',
            'state_agency_id' => 'required',
            'state_id' => 'required'
        ]);

        try{
            $update_state_tender = StateTender::where('state_tender_id', $request->state_tender_id)->update([
                'state_notice_id' => $request->state_notice_id,
                'state_agency_id' => $request->state_agency_id,
                'category_id' => $request->category_id,
                'state_id' => $request->state_id,
                'posted_date' => $request->posted_date,
                'upload_type' => 'manual',
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
            'state_notice_id' => 'required',
            'category_id' => 'required',
            'state_agency_id' => 'required',
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
        $data['upload_type'] = 'manual';
        $data['tender_number'] = str_replace($data['tender_no'], '-', '');

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

    public function getStateTendersRange(Request $request){
        $data = $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'region' => 'required'
        ]);

        $state_tenders = StateTender::whereBetween('posted_date', [$request->from_date.' 00:00:00', $request->to_date,' 23:59:59'])->get();
        return StateTenderResource::collection($state_tenders);
    }

    public function deleteStateTendersRange(Request $request){
        $data = $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'region' => 'required'
        ]);

        try {

            StateAttachment::whereHas('StateTender', function($que) use($request){
                $que->whereBetween('posted_date', [$request->from_date.' 00:00:00', $request->to_date,' 23:59:59']);
            })->delete();

            StateContact::whereHas('StateTender', function($que) use($request){
                $que->whereBetween('posted_date', [$request->from_date.' 00:00:00', $request->to_date,' 23:59:59']);
            })->delete();

            StateOfficeAddress::whereHas('StateTender', function($que) use($request){
                $que->whereBetween('posted_date', [$request->from_date.' 00:00:00', $request->to_date,' 23:59:59']);
            })->delete();

            $state_tender = StateTender::whereBetween('posted_date', [$request->from_date.' 00:00:00', $request->to_date,' 23:59:59'])->delete();
            return $state_tender;
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
    }

    // public function updateStateBids(Request $request)
    // {
    //     $folderPath = public_path() . '/attachments/06_MyFloridaMarketPlace.xlsx';
    
    //     if (file_exists($folderPath)) {
    //         try {
    //             Excel::import(new StateTenderImport($folderPath, $request->folder), $folderPath);
    //         } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
    //             return response()->json([
    //                 'message' => 'Error importing file: ' . $folderPath,
    //                 'error' => $e->failures()
    //             ], 500);
    //         }
    //     } else {
    //         return response()->json([
    //             'message' => 'File not found in the public directory.'
    //         ], 404);
    //     }

    //     return response()->json([
    //         'message' => 'Data imported successfully'
    //     ]);
    // }    
}
