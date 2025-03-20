<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use Illuminate\Support\Facades\Cache;

class StateController extends Controller
{
    public function getStates(Request $request)
    {
    	return  State::where('country_id',$request->country_id)->get();
    }
}
