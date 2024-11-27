<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use App\Http\Resources\UserSubscriptionResource;

class SubscriptionPlanController extends Controller
{
    public function getSubscriptionPlans(){
    	return SubscriptionPlan::whereIn('plan', ['Semi-Annual', 'Annual'])->get();
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
}
