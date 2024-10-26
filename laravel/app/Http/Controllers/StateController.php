<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use Illuminate\Support\Facades\Cache;

class StateController extends Controller
{
    public function getStates(Request $request)
    {
    	$request->validate([
    		'country_id' => 'required'
    	]);
    	$cacheKey = 'states';
        $states = Cache::remember($cacheKey, 60 * 60, function () use($request) {
        	return  State::where('country_id',$request->country_id)->get();
        });
        return $states;

    }
}
