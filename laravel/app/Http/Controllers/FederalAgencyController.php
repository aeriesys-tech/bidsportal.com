<?php

namespace App\Http\Controllers;
use App\Models\FederalAgency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FederalAgencyController extends Controller
{
	public function getFederalAgencies(Request $request){
		$cacheKey = 'federal_agencies';
        $federal_agencies = Cache::remember($cacheKey, 60 * 60, function () use($request) {
        	return FederalAgency::orderBy('agency_name')->get();
        });
        return $federal_agencies;
	}
}
