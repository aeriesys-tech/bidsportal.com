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
        if($request->search){
            $search_results = Psc::where(function ($query) use ($request) {
                $query->where('psc_code', 'like', '%' . $request->search . '%')
                      ->orWhere('psc_description', 'like', '%' . $request->search . '%');
            })
            ->select('psc_code')
            ->pluck('psc_code');

            $search_results_array = is_array($search_results) ? $search_results : $search_results->toArray();
            $psc_codes = [];
            foreach ($search_results_array as $code) {
                for ($i = 1; $i <= strlen($code); $i++) {
                    $new_code = substr($code, 0, $i);
                    if(!in_array($new_code, $psc_codes)){
                        $psc_codes[] = $new_code;
                    }
                }
            }

            $child_psc_ids = Psc::whereNull('psc_parent_id')
            ->where(function ($query) use ($search_results_array) {
                foreach ($search_results_array as $code) {
                    $query->orWhereRaw('psc_code LIKE ?', [substr($code, 0, 2) . '%']);
                }
            })
            ->pluck('psc_id');
            $psc = Psc::select('psc_id', 'psc_code', 'psc_description')
                    ->whereIn('psc_id', $child_psc_ids)->whereNull('psc_parent_id')->get();

        }else{
    	    $cacheKey = 'pscs';
    	    $psc = Cache::remember($cacheKey, 60 * 60, function () {
    	        return Psc::with('Psc')->select('psc_id', 'psc_code', 'psc_description')
    	                  ->whereNull('psc_parent_id')
    	                  ->get();
    	    });
            $psc_codes = [];
        }
        $psc_resource = PscResource::collection($psc); 
        return (['pscs' => $psc_resource, 'psc_codes' => $psc_codes]);
    }

    public function getPrimaryPscs(Request $request)
    {
        $pscs = Psc::whereNull('psc_parent_id')->get();
        return PscPrimaryResource::collection($pscs);
    }
}
