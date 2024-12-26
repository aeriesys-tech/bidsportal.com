<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserStateInterest;
use App\Http\Resources\UserStateInterestResource;

class UserStateInterestController extends Controller
{
    public function addStateInterest(Request $request){
    	$data = $request->validate([
    		'user_id' => 'required',
    		'state_tender_id' => 'required',
    		'interest_type' => 'required'
    	]);

    	return UserStateInterest::updateOrCreate([
    		'user_id' => $request->user_id,
    		'state_tender_id' => $request->state_tender_id
    	], [
    		'interest_type' => $request->interest_type

    	]);
    }

    public function paginateStateInterests(Request $request){
    	$data = $request->validate([
    		'user_id' => 'required',
    		'state_tender_id' => 'required'
    	]);
    	$user_state_interest = UserStateInterest::where('user_id', $request->user_id)->where('state_tender_id', $request->state_tender_id)->first();

    	if($user_state_interest){
    		$query = UserStateInterest::query();
    		$query->where('state_tender_id', $request->state_tender_id);
    		$query->orderBy('user_state_interest_id', 'DESC');
	        $state_interests = $query->paginate(10); 
	        return ([
	        	'state_interest' => new UserStateInterestResource($user_state_interest),
	        	'state_interests' => UserStateInterestResource::collection($state_interests)
	        ]);
    	}else{
    		return response()->json([
    			'state_interest' => [
    				'user_state_interest_id' => '',
    				'user_id' => $request->user_id,
    				'state_tender_id' => $request->state_tender_id,
    				'interest_type' => '',
    				'status' => true
    			]
    		]);
    	}
    }

    public function deleteStateInterest(Request $request){
    	$data = $request->validate([
    		'user_state_interest_id' => 'required'
    	]);
    	try{
	    	UserStateInterest::where('user_state_interest_id', $request->user_state_interest_id)->delete();
	    }catch (\Exception $e) {
		    return response()->json(['error' => 'Error deleting the interest', 'details' => $e->getMessage()], 422);
		}
    }
}
