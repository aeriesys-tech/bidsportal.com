<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserFederalInterest;
use App\Http\Resources\UserFederalInterestResource;

class UserFederalInterestController extends Controller
{
    public function addFederalInterest(Request $request){
    	$data = $request->validate([
    		'user_id' => 'required',
    		'federal_tender_id' => 'required',
    		'interest_type' => 'required'
    	]);

    	return UserFederalInterest::updateOrCreate([
    		'user_id' => $request->user_id,
    		'federal_tender_id' => $request->federal_tender_id
    	], [
    		'interest_type' => $request->interest_type

    	]);
    }

    public function paginateFederalInterests(Request $request){
    	$data = $request->validate([
    		'user_id' => 'required',
    		'federal_tender_id' => 'required'
    	]);
    	$user_federal_interest = UserFederalInterest::where('user_id', $request->user_id)->where('federal_tender_id', $request->federal_tender_id)->first();

    	if($user_federal_interest){
    		$query = UserFederalInterest::query();
    		$query->where('federal_tender_id', $request->federal_tender_id);
    		$query->orderBy('user_federal_interest_id', 'DESC');
	        $federal_interests = $query->paginate(10); 
	        return ([
	        	'federal_interest' => new UserFederalInterestResource($user_federal_interest),
	        	'federal_interests' => UserFederalInterestResource::collection($federal_interests)
	        ]);
    	}else{
    		return response()->json([
    			'federal_interest' => [
    				'user_federal_interest_id' => '',
    				'user_id' => $request->user_id,
    				'federal_tender_id' => $request->federal_tender_id,
    				'interest_type' => '',
    				'status' => true
    			],
                'federal_interests' => []
    		]);
    	}
    }

    public function deleteFederalInterest(Request $request){
    	$data = $request->validate([
    		'user_federal_interest_id' => 'required'
    	]);
    	try{
	    	UserFederalInterest::where('user_federal_interest_id', $request->user_federal_interest_id)->delete();
	    }catch (\Exception $e) {
		    return response()->json(['error' => 'Error deleting the interest', 'details' => $e->getMessage()], 422);
		}
    }
}
