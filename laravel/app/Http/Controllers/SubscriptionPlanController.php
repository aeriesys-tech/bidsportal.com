<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use App\Http\Resources\UserSubscriptionResource;
use App\Http\Resources\SubscriptionPlanResource;

class SubscriptionPlanController extends Controller
{
    public function getSubscriptionPlans(){
    	return SubscriptionPlan::whereIn('plan', ['Semi-Annual', 'Annual', 'Trial'])->get();
    }

   	public function paginateUserSubscriptions(Request $request)
    {
        $request->validate([
            'order_by' => 'required',
            'per_page' => 'required|numeric',
            'keyword' => 'required'
        ]);
    	$query = UserSubscription::query();

        if($request->search!='')
		{
			$query->where('payment_method', 'like', "%$request->search%")->orWhere('validity', 'like', "$request->search%")
				->orWhereHas('User', function($que) use($request){
					$que->where('name', 'like', "$request->search%");
				});
		}
    	$users = $query->orderBy($request->keyword,$request->order_by)->paginate($request->per_page);
        return UserSubscriptionResource::collection($users);
    }

    public function paginateSubscriptionPlans(Request $request)
    {
        $request->validate([
            'order_by' => 'required',
            'per_page' => 'required|numeric',
            'keyword' => 'required'
        ]);
    	$query = SubscriptionPlan::query();

        if($request->search!='')
		{
			$query->where('plan', 'like', "%$request->search%")->orWhere('month', 'like', "$request->search%")
            ->orWhere('days', 'like', "$request->search%")->orWhere('description', 'like', "$request->search%");
		}

    	$plans = $query->orderBy($request->keyword,$request->order_by)->paginate($request->per_page);
        return SubscriptionPlanResource::collection($plans);
    }

    public function addSubscriptionPlan(Request $request)
    {
        $data = $request->validate([
            'plan' => 'required|unique:subscription_plans,plan', 
            'price' => 'required', 
            'days' => 'required', 
            'month' => 'required',
            'description' => 'required', 
            'discount' => 'required',
            'is_default' => 'required'
        ]);

        $plan = SubscriptionPlan::create($data);
        return response()->json([
            "message" => "Subscription Plan Created Scuccessfully"
        ]);
    }

    public function getSubscriptionPlan(Request $request)
    {
        $request->validate([
            'subscription_plan_id' => 'required|exists:subscription_plans,subscription_plan_id' 
        ]);

        $plan = SubscriptionPlan::where('subscription_plan_id', $request->subscription_plan_id)->first();
        return new SubscriptionPlanResource($plan);
    }

    public function updateSubscriptionPlan(Request $request)
    {
        $data = $request->validate([
            'subscription_plan_id' => 'required|exists:subscription_plans,subscription_plan_id',
            'plan' => 'required|unique:subscription_plans,plan,'.$request->subscription_plan_id.',subscription_plan_id', 
            'price' => 'required', 
            'days' => 'required', 
            'month' => 'required',
            'description' => 'required', 
            'discount' => 'required',
            'is_default' => 'required'
        ]);

        $plan = SubscriptionPlan::where('subscription_plan_id', $request->subscription_plan_id)->first();
        $plan->update($data);

        return response()->json([
            "message" => "Subscription Plan Updated Scuccessfully"
        ]);
    }

    public function deleteSubscriptionPlan(Request $request)
    {
        $request->validate([
            'subscription_plan_id' => 'required|exists:subscription_plans,subscription_plan_id'
        ]);

        $plan = SubscriptionPlan::where('subscription_plan_id', $request->subscription_plan_id)->delete();
        return response()->json([
            "message" => "Subscription Plan Deleted Successfully"
        ]);
    }
}
