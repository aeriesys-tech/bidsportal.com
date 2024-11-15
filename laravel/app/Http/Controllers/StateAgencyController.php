<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StateAgency;
use Illuminate\Support\Facades\Cache;

class StateAgencyController extends Controller
{
    public function getStateAgencies(Request $request){
		$cacheKey = 'state_agencies';
        $state_agencies = Cache::remember($cacheKey, 60 * 60, function () use($request) {
        	return StateAgency::orderBy('state_agency_name')->get();
        });
        return $state_agencies;
	}
}
