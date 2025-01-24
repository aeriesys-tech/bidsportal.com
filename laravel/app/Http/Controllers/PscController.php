<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Psc;
use App\Http\Resources\PscResource;
use App\Http\Resources\PscPrimaryResource;
use Illuminate\Support\Facades\Cache;

class PscController extends Controller
{
    public function getPscs(Request $request)
    {
	    $cacheKey = 'pscs';
	    $psc = Cache::remember($cacheKey, 60 * 60, function () {
	        return Psc::with('Psc')->select('psc_id', 'psc_code', 'psc_description')
	                  ->whereNull('psc_parent_id')
	                  ->get();
	    });
	    return PscResource::collection($psc);
    }

    public function getPrimaryPscs(Request $request)
    {
        $pscs = Psc::whereNull('psc_parent_id')->get();
        return PscPrimaryResource::collection($pscs);
    }
}
