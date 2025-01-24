<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Naics;
use App\Http\Resources\NaicsResource;
use App\Http\Resources\NaicsPrimaryResource;
use Illuminate\Support\Facades\Cache;

class NaicsController extends Controller
{
    public function getNaics(Request $request)
    {
        $cacheKey = 'naics';
        $naics = Cache::remember($cacheKey, 60 * 60, function () {
            return Naics::with('Naics')->select('naics_id', 'naics_code', 'naics_description')
                      ->whereNull('naics_parent_id')
                      ->get();
        });
        return NaicsResource::collection($naics);
    }

    public function getPrimaryNaics(Request $request)
    {
        $naics = Naics::whereNull('naics_parent_id')->get();
        return NaicsPrimaryResource::collection($naics);
    }
}
