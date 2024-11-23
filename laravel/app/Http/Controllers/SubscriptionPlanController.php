<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;

class SubscriptionPlanController extends Controller
{
    public function getSubscriptionPlans(){
    	return SubscriptionPlan::whereIn('plan', ['Semi-Annual', 'Annual'])->get();
    }
}
