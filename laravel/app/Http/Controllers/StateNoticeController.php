<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StateNotice;
use Illuminate\Support\Facades\Cache;

class StateNoticeController extends Controller
{
    public function getStateNotices(Request $request){
    	$cacheKey = 'state_notice';
        $state_notices = Cache::remember($cacheKey, 60 * 60, function () {
            return StateNotice::where('sort', '!=', 0)->orderBy('sort')->get();
        });
        return $state_notices;
    }
}
