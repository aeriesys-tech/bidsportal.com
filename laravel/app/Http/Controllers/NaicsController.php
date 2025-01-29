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
            // $parent_results = Naics::whereNull('naics_parent_id')
            // ->where(function ($query) use ($request) {
            //     $query->where('naics_code', 'like', '%' . $request->search . '%')
            //           ->orWhere('naics_description', 'like', '%' . $request->search . '%');
            // })
            // ->pluck('naics_id');

            $search_results = Naics::where(function ($query) use ($request) {
                $query->where('naics_code', 'like', '%' . $request->search . '%')
                      ->orWhere('naics_description', 'like', '%' . $request->search . '%');
            })
            ->select('naics_code')
            ->pluck('naics_code');

$additional_codes = []; // Array to store additional codes to add to $search_results
$search_results_array = is_array($search_results) ? $search_results : $search_results->toArray();
$naics_codes = [];

foreach ($search_results_array as $code) {
    // Check the start of the string and add related codes
    if (str_starts_with($code, "32") || str_starts_with($code, "33")) {
        if (!in_array('31-33', $search_results_array)) {
            $search_results_array[] = "31-33"; // Add 31
        }
        if (!in_array('31-33', $naics_codes)) {
            $naics_codes[] = "31-33";
        }
    } elseif (str_starts_with($code, "45")) {
        if (!in_array('44-45', $search_results_array)) {
            $search_results_array[] = "44-45"; // Add 31
        }
        if (!in_array('44-45', $naics_codes)) {
            $naics_codes[] = "44-45"; // Add 44
        }
    } elseif (str_starts_with($code, "49")) {
        if (!in_array('48-49', $search_results_array)) {
            $search_results_array[] = "48-49"; // Add 31
        }
        if (!in_array('48-49', $naics_codes)) {
            $naics_codes[] = "48-49"; // Add 48
        }
    }else{
        if (!in_array($code, $naics_codes)) {
            $naics_codes[] = $code;     
        }
    }
    $naics_codes[] = substr($code, 0, 2);
    $naics_codes[] = substr($code, 0, 3);
    $naics_codes[] = substr($code, 0, 4);
}

// Merge additional codes into search_results
// $search_results = array_merge($search_results, $additional_codes);

// Build the query
$childe_naics_ids = Naics::whereNull('naics_parent_id')
    ->where(function ($query) use ($search_results_array) {
        foreach ($search_results_array as $code) {
            $query->orWhereRaw('naics_code LIKE ?', [substr($code, 0, 2) . '%']);
        }
    })
    ->pluck('naics_id');

            // $all_parents = $parent_results->merge($childe_naics_ids)->unique('naics_id')->values();

            // $all_parent_codes = $parent_results->merge($child_results);

            // $naics_codes = Naics::whereIn('naics_id', $all_parent_codes)->pluck('naics_code');


            $naics = Naics::select('naics_id', 'naics_code', 'naics_description')
                    ->whereIn('naics_id', $childe_naics_ids)->whereNull('naics_parent_id')->get();

        }else{
            $cacheKey = 'naics';
            $naics = Cache::remember($cacheKey, 60 * 60, function () {
                return Naics::select('naics_id', 'naics_code', 'naics_description')
                          ->whereNull('naics_parent_id')
                          ->get();
            });
            $search_results = [];
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
