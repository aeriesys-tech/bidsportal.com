<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserSubscription;

class UserSubscriptionController extends Controller
{
    public function getUserSubscriptions(Request $request){
    	$user_subscriptions = UserSubscription::where('user_id', $request->user_id)->get();
    	return $user_subscriptions;
    }

    public function getActiveSubscription(Request $request){
    	$user_subscription = UserSubscription::where('user_id', $request->user_id)->where('active_status', 'active')->first();
    	return $user_subscription;
    }
}
