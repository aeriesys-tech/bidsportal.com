<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserInternationalInterest;
use App\Http\Resources\UserInternationalInterestResource;

class UserInternationalInterestController extends Controller
{
    public function addInternationalInterest(Request $request){
    	$data = $request->validate([
    		'user_id' => 'required',
    		'international_tender_id' => 'required',
    		'interest_type' => 'required'
    	]);

    	return UserInternationalInterest::updateOrCreate([
    		'user_id' => $request->user_id,
    		'international_tender_id' => $request->international_tender_id
    	], [
    		'interest_type' => $request->interest_type

    	]);
    }

    public function paginateInternationalInterests(Request $request){
    	$data = $request->validate([
    		'user_id' => 'required',
    		'international_tender_id' => 'required'
    	]);
    	$user_international_interest = UserInternationalInterest::where('user_id', $request->user_id)->where('international_tender_id', $request->international_tender_id)->first();

    	if($user_international_interest){
    		$query = UserInternationalInterest::query();
    		$query->where('international_tender_id', $request->international_tender_id);
    		$query->orderBy('user_international_interest_id', 'DESC');
	        $international_interests = $query->paginate(10); 
	        return ([
	        	'international_interest' => new UserInternationalInterestResource($user_international_interest),
	        	'international_interests' => UserInternationalInterestResource::collection($international_interests)
	        ]);
    	}else{
    		return response()->json([
    			'international_interest' => [
    				'user_international_interest_id' => '',
    				'user_id' => $request->user_id,
    				'international_tender_id' => $request->international_tender_id,
    				'interest_type' => '',
    				'status' => true
    			],
                'international_interests' => []
    		]);
    	}
    }

    public function deleteInternationalInterest(Request $request){
    	$data = $request->validate([
    		'user_international_interest_id' => 'required'
    	]);
    	try{
	    	UserInternationalInterest::where('user_international_interest_id', $request->user_international_interest_id)->delete();
	    }catch (\Exception $e) {
		    return response()->json(['error' => 'Error deleting the interest', 'details' => $e->getMessage()], 422);
		}
    }
}
