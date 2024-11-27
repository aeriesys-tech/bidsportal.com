<?php

namespace App\Http\Controllers;
use App\Models\UserPayment;
use Illuminate\Http\Request;
use App\Http\Resources\UserPaymentResource;
use Auth;

class UserPaymentController extends Controller
{
    public function getUserPayment(Request $request){
    	$user_payment = UserPayment::where('user_payment_id', $request->user_payment_id)->first();
    	return new UserPaymentResource($user_payment);
    }

    public function getUserPayments(Request $request){
    	$user = Auth::User();
    	if($user){
	    	$user_payments = UserPayment::where('user_id', $user->user_id)->get();
    		return UserPaymentResource::collection($user_payments);
    	}else{
    		return response()->json([
    			'message' => 'Unauthorised'
    		]);
    	}
    }
}
