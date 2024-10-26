<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SetAside;
use Illuminate\Support\Facades\Cache;

class SetAsideController extends Controller
{
    public function getSetAsides(Request $request)
    {
    	$cacheKey = 'set_aside';
        $set_asides = Cache::remember($cacheKey, 60 * 60, function () {
	    	return SetAside::where('sort', '!=', 0)->orderBy('sort')->get();
        });
        return $set_asides;
    }
}
