<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Naics;
use App\Http\Resources\NaicsResource;
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

    	// $query = Naics::query();
    	// $naics = $query->whereNull('naics_parent_id')->get();
        // if (Cache::has('naics')) {
        //     $naics = Cache::get('naics');
        // }else{
        //     $query = Naics::query();
        //     if($request->search){
        //         $arr = str_split($request->search);
        //         $search_arr = [];
        //         $search_element = "";
        //         foreach ($arr as $value) {
        //             if(!$search_element){
        //                 $search_element = $value;
        //                 array_push($search_arr, $search_element);
        //             }else{
        //                 $search_element = $search_element.''.$value;
        //                 array_push($search_arr, $search_element);
        //             }
        //         }
        //         $remove_first_element = array_shift($search_arr);
        //         $query->where('naics_desc', 'like', "%$request->search%");
        //         foreach ($search_arr as $element) {
        //             $query->orWhere('naics_code', 'like', "%$element%")->where('naics_parent_id', 0);
        //         }
        //     }
        //     $naics = $query->whereNull('naics_parent_id')->get();
        //     $user_id = 1;   
        //     Cache::forever('naics', $naics);
        // } 
        // return NaicsResource::collection($naics);
    }
}
