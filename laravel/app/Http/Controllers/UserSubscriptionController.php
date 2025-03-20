<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserSubscription;
use App\Models\SubscriptionPlan;
use App\Http\Resources\UserSubscriptionResource;
use Carbon\Carbon;

class UserSubscriptionController extends Controller
{
    public function getUserSubscriptions(Request $request){
    	$user_subscriptions = UserSubscription::where('user_id', $request->user_id)->get();
    	return UserSubscriptionResource::collection($user_subscriptions);
    }

    // public function getActiveSubscription(Request $request){
    // 	$user_subscription = UserSubscription::where('user_id', $request->user_id)->where('active_status', 'active')->first();
    // 	return new UserSubscriptionResource($user_subscription);
    // }

    public function getActiveSubscription(Request $request)
    {
    	$user_subscription = UserSubscription::where('user_id', $request->user_id)->orderBy('created_at', 'desc')->first();
        if($user_subscription){
        	return new UserSubscriptionResource($user_subscription);
        }else{
            return $user_subscription = null;
        }
    }

    public function addTrialSubscription(Request $request){
    	$data = $request->validate([
    		'user_id' => 'required'
    	]);
    	UserSubscription::where('user_id', $request->user_id)->where('active_status', 'like', 'active')->update([ 
            'active_status' => 'inactive'
        ]);
        $subscription_plan = SubscriptionPlan::where('plan', 'like', 'Trial')->first();
        $user_subscription = null;
        if ($subscription_plan) {
            $validity_from = Carbon::today();
            $validity_to = $validity_from->copy()->addDays($subscription_plan->days);
            $user_subscription = UserSubscription::create([
                'user_id' => $request->user_id,
                'active_status' => 'active',
                'validity' => $subscription_plan->days,
                'valid_from' => $validity_from,
                'valid_to' => $validity_to,
                'subscription_plan_id' => $subscription_plan->subscription_plan_id
            ]);
        }
     	return $user_subscription;  
    }
}
