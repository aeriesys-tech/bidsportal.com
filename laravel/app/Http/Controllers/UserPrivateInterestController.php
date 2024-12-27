<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserPrivateInterest;
use App\Http\Resources\UserPrivateInterestResource;

class UserPrivateInterestController extends Controller
{
    public function addPrivateInterest(Request $request){
    	$data = $request->validate([
    		'user_id' => 'required',
    		'private_tender_id' => 'required',
    		'interest_type' => 'required'
    	]);

    	return UserPrivateInterest::updateOrCreate([
    		'user_id' => $request->user_id,
    		'private_tender_id' => $request->private_tender_id
    	], [
    		'interest_type' => $request->interest_type

    	]);
    }

    public function paginatePrivateInterests(Request $request){
    	$data = $request->validate([
    		'user_id' => 'required',
    		'private_tender_id' => 'required'
    	]);
    	$user_private_interest = UserPrivateInterest::where('user_id', $request->user_id)->where('private_tender_id', $request->private_tender_id)->first();

    	if($user_private_interest){
    		$query = UserPrivateInterest::query();
    		$query->where('private_tender_id', $request->private_tender_id);
    		$query->orderBy('user_private_interest_id', 'DESC');
	        $private_interests = $query->paginate(10); 
	        return ([
	        	'private_interest' => new UserPrivateInterestResource($user_private_interest),
	        	'private_interests' => UserPrivateInterestResource::collection($private_interests)
	        ]);
    	}else{
    		return response()->json([
    			'private_interest' => [
    				'user_private_interest_id' => '',
    				'user_id' => $request->user_id,
    				'private_tender_id' => $request->private_tender_id,
    				'interest_type' => '',
    				'status' => true
    			],
                'private_interests' => []
    		]);
    	}
    }

    public function deletePrivateInterest(Request $request){
    	$data = $request->validate([
    		'user_private_interest_id' => 'required'
    	]);
    	try{
	    	UserPrivateInterest::where('user_private_interest_id', $request->user_private_interest_id)->delete();
	    }catch (\Exception $e) {
		    return response()->json(['error' => 'Error deleting the interest', 'details' => $e->getMessage()], 422);
		}
    }
}
