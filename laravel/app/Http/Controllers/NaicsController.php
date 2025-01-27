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
        if($request->search){
            $parent_results = Naics::whereNull('naics_parent_id')
            ->where(function ($query) use ($request) {
                $query->where('naics_code', 'like', '%' . $request->search . '%')
                      ->orWhere('naics_description', 'like', '%' . $request->search . '%');
            })
            ->pluck('naics_id');
            $child_results = Naics::where(function ($query) use ($request) {
                $query->where('naics_code', 'like', '%' . $request->search . '%')
                      ->orWhere('naics_description', 'like', '%' . $request->search . '%');
            })
            ->select('naics_parent_id')
            ->whereNotNull('naics_parent_id')
            ->distinct()
            ->pluck('naics_parent_id');

            $all_parents = $parent_results->merge($child_results)->unique('naics_id')->values();

            $all_parent_codes = $parent_results->merge($child_results);

            $naics_codes = Naics::whereIn('naics_id', $all_parent_codes)->pluck('naics_code');


            $naics = Naics::select('naics_id', 'naics_code', 'naics_description')
                    ->whereIn('naics_id', $all_parents)->whereNull('naics_parent_id')->get();

        }else{
            $cacheKey = 'naics';
            $naics = Cache::remember($cacheKey, 60 * 60, function () {
                return Naics::select('naics_id', 'naics_code', 'naics_description')
                          ->whereNull('naics_parent_id')
                          ->get();
            });
            $naics_codes = [];
        }
        $naics_resource = NaicsResource::collection($naics); 
        return (['naics' => $naics_resource, 'naics_codes' => $naics_codes]);
    }

    public function getPrimaryNaics(Request $request)
    {
        $naics = Naics::whereNull('naics_parent_id')->get();
        return NaicsPrimaryResource::collection($naics);
    }
}
