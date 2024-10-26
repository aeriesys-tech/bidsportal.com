<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FederalNotice;
use Illuminate\Support\Facades\Cache;

class FederalNoticeController extends Controller
{
    public function getFederalNotices(Request $request){
    	$cacheKey = 'federal_notice';
        $federal_notices = Cache::remember($cacheKey, 60 * 60, function () {
            return FederalNotice::where('sort', '!=', 0)->orderBy('sort')->get();
        });
        return $federal_notices;
    }
}
