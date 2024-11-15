<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\StateFilter;
use App\Models\StateFilterKeyword;
use App\Models\StateFilterNotice;
use App\Models\StateFilterState;
use App\Models\StateFilterSetAside;
use App\Models\StateFilterAgency;
use App\Http\Resources\StateFilterResource;
use Auth;

class StateFilterController extends Controller
{
	public function getStateFilters(Request $request)
    {
    	$user = Auth::User();
    	if($user){
		    $state_filters = StateFilter::where('user_id', $user->user_id)->get();
		    // return $state_filters;
		    return StateFilterResource::collection($state_filters);
		}else{
			return response()->json(['message' => 'Please sign in'], 422);
		}
	}

    public function addStateFilters(Request $request)
	{
	    $user = Auth::User(); 

	    $data = $request->validate([
	        'state_filter_name' => 'required',
	        'posted_date' => 'sometimes|nullable',
	        'posted_from_date' => 'sometimes|nullable',
	        'posted_to_date' => 'sometimes|nullable',
	        'response_date' => 'sometimes|nullable',
	        'response_from_date' => 'sometimes|nullable',
	        'response_to_date' => 'sometimes|nullable',
	        'state_notices' => 'sometimes|nullable|array',
	        'states' => 'sometimes|nullable|array',
	        'categories' => 'sometimes|nullable|array',
	        'state_agencies' => 'sometimes|nullable|array',
	        'keywords' => 'sometimes|nullable|array', 
	        'statuses' => 'sometimes|nullable|array'
	    ]);

	    if ($user) {

	    	try{
		        $state_filter = StateFilter::whereHas('StateFilterKeywords', function($que) use($request){
		        	$que->whereIn('keyword', $request->keywords);
		        })->where('user_id', $user->user_id)->first();
	 
		        if (!$state_filter){
			        $state_filter = StateFilter::create([
			            'user_id' => $user->user_id,
					    'state_filter_name' => $request->state_filter_name,
					    'posted_date' => $request->posted_date ?: null,
					    'active' => $request->active ?: null,
					    'expired' => $request->expired ?: null,
					    'posted_from_date' => $request->posted_from_date ?: null,
					    'posted_to_date' => $request->posted_to_date ?: null,
					    'response_date' => $request->response_date ?: null,
					    'response_from_date' => $request->response_from_date ?: null,
					    'response_to_date' => $request->response_to_date ?: null
			        ]);
			    }else {
	                // Delete previous associations if the filter already exists
	                $this->deleteAssociations($state_filter);
	            }

		        // Handle the related data associations
		        if ($request->has('keywords')) {
		            foreach ($request->keywords as $keyword) {
		                StateFilterKeyword::updateOrCreate(
		                    ['state_filter_id' => $state_filter->state_filter_id, 'keyword' => $keyword]
		                );
		            }
		        }

		        if ($request->has('state_notices')) {
		            foreach ($request->state_notices as $notice) {
		                StateFilterNotice::updateOrCreate(
		                    ['state_filter_id' => $state_filter->state_filter_id, 'state_notice_id' => $notice]
		                );
		            }
		        }

		        if ($request->has('states')) {
		            foreach ($request->states as $state) {
		                StateFilterState::updateOrCreate(
		                    ['state_filter_id' => $state_filter->state_filter_id, 'state_id' => $state]
		                );
		            }
		        }

		        if ($request->has('state_agencies')) {
		            foreach ($request->state_agencies as $agency) {
		                StateFilterAgency::updateOrCreate(
		                    ['state_filter_id' => $state_filter->state_filter_id, 'state_agency_id' => $agency]
		                );
		            }
		        }

		        return $state_filter;
		    } catch (\Exception $e) {
	            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
	        }
	    }
	}

	private function deleteAssociations($state_filter)
	{
	    // Delete all existing associated records for this state_filter
	    try{
		    StateFilterKeyword::where('state_filter_id', $state_filter->state_filter_id)->delete();
		    StateFilterStatus::where('state_filter_id', $state_filter->state_filter_id)->delete();
		    StateFilterNotice::where('state_filter_id', $state_filter->state_filter_id)->delete();
		    StateFilterState::where('state_filter_id', $state_filter->state_filter_id)->delete();
		    StateFilterCategory::where('state_filter_id', $state_filter->state_filter_id)->delete();
		    StateFilterAgency::where('state_filter_id', $state_filter->state_filter_id)->delete();
		} catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
        }
	}
}
