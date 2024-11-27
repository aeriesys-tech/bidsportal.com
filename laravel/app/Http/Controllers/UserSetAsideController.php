<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserSetAside;

class UserSetAsideController extends Controller
{
    public function getUserSetAsideIds(Request $request){
    	$user_set_aside_ids = UserSetAside::where('user_id', $request->user_id)->get('set_aside_id')->toArray();
    	return $user_set_aside_ids;
    }
}
