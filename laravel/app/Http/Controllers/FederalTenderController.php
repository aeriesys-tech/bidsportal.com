<?php

namespace App\Http\Controllers;
use App\Models\FederalTender;
use App\Http\Resources\FederalTenderResource;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;

class FederalTenderController extends Controller
{
    public function paginateFederalTenders(Request $request)
    {
    	$request->validate([
            'order_by' => 'required',
            'per_page' => 'required|numeric'
        ]);
    	$query = FederalTender::query();

        if($request->active){
            $query->whereDate('expiry_date', '>=', date('Y-m-d'));
        }

        if($request->expired){
            $query->whereDate('expiry_date', '<', date('Y-m-d'));   
        }

    	if($request->posted_date){
            $previous_date = Carbon::now()->sub(CarbonInterval::createFromDateString($request->posted_date))->format('Y-m-d');
    		$query->whereDate('posted_date', '>=', $previous_date);
    	}

        if($request->posted_from_date && $request->posted_to_date){
            $query->whereDate('posted_date', '>=', $request->posted_from_date)->whereDate('posted_date', '<=', $request->posted_to_date);
        }

        if($request->response_date){
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
            if (is_string($request->keywords)) {
                $keywords = array_map('trim', explode(',', $request->keywords));
            } else {
                $keywords = array_map('trim', $request->keywords);
            }

            $searchQuery = implode(' ', $keywords); // Join keywords for full-text search

            // Search for matches
            $query->whereRaw("MATCH(tender_no, title) AGAINST(? IN NATURAL LANGUAGE MODE)", [$searchQuery]);

            $query->orderByRaw("MATCH(tender_no, title) AGAINST(? IN NATURAL LANGUAGE MODE) DESC, federal_tender_id DESC", [$searchQuery]);
        }


	    $query->orderBy('federal_tender_id', 'DESC');
    	$federal_tenders = $query->paginate($request->per_page); 
        return FederalTenderResource::collection($federal_tenders);
    }
}
