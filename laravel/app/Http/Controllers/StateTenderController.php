<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\StateTender;
use App\Models\User;
use App\Http\Resources\StateTenderResource;
use App\Http\Resources\StateTenderDetailResource;
use Carbon\Carbon;
use Carbon\CarbonInterval;

class StateTenderController extends Controller
{
    public function paginateStateTenders(Request $request)
    {
    	$request->validate([
            'order_by' => 'required',
            'per_page' => 'required|numeric'
        ]);
    	$query = StateTender::query();

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
}
