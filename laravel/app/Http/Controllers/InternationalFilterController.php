<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\InternationalFilter;
use App\Models\InternationalFilterKeyword;
use App\Models\InternationalFilterNotice;
use App\Models\InternationalFilterState;
use App\Models\InternationalFilterSetAside;
use App\Models\InternationalFilterAgency;
use App\Http\Resources\InternationalFilterResource;

class InternationalFilterController extends Controller
{
    public function getInternationalFilters(Request $request)
    {
    	$data = $request->validate([
    		'user_id' => 'required'
    	]);
	    $international_filters = InternationalFilter::where('user_id', $request->user_id)->get();
	    return InternationalFilterResource::collection($international_filters);
	}

    public function addInternationalFilters(Request $request)
	{
    	$data = $request->validate([
    		'user_id' => 'required'
    	]);

	    $data = $request->validate([
	        'international_filter_name' => 'required',
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

	    	try{
		        $international_filter = InternationalFilter::whereHas('InternationalFilterKeywords', function($que) use($request){
		        	$que->whereIn('keyword', $request->keywords);
		        })->where('user_id', $request->user_id)->first();
	 
		        if (!$international_filter){
			        $international_filter = InternationalFilter::create([
			            'user_id' => $request->user_id,
					    'international_filter_name' => $request->international_filter_name,
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
	                $this->deleteAssociations($international_filter);
	            }

		        // Handle the related data associations
		        if ($request->has('keywords')) {
		            foreach ($request->keywords as $keyword) {
		                InternationalFilterKeyword::updateOrCreate(
		                    ['international_filter_id' => $international_filter->international_filter_id, 'keyword' => $keyword]
		                );
		            }
		        }

		        if ($request->has('state_notices')) {
		            foreach ($request->state_notices as $notice) {
		                InternationalFilterNotice::updateOrCreate(
		                    ['international_filter_id' => $international_filter->international_filter_id, 'state_notice_id' => $notice]
		                );
		            }
		        }

		        if ($request->has('states')) {
		            foreach ($request->states as $state) {
		                InternationalFilterState::updateOrCreate(
		                    ['international_filter_id' => $international_filter->international_filter_id, 'state_id' => $state]
		                );
		            }
		        }

		        if ($request->has('state_agencies')) {
		            foreach ($request->state_agencies as $agency) {
		                InternationalFilterAgency::updateOrCreate(
		                    ['international_filter_id' => $international_filter->international_filter_id, 'state_agency_id' => $agency]
		                );
		            }
		        }

		        return $international_filter;
		    } catch (\Exception $e) {
	            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
	        }
	}

	private function deleteAssociations($international_filter)
	{
	    // Delete all existing associated records for this state_filter
	    try{
		    InternationalFilterKeyword::where('international_filter_id', $international_filter->international_filter_id)->delete();
		    InternationalFilterStatus::where('international_filter_id', $international_filter->international_filter_id)->delete();
		    InternationalFilterNotice::where('international_filter_id', $international_filter->international_filter_id)->delete();
		    InternationalFilterState::where('international_filter_id', $international_filter->international_filter_id)->delete();
		    InternationalFilterCategory::where('international_filter_id', $international_filter->international_filter_id)->delete();
		    InternationalFilterAgency::where('international_filter_id', $international_filter->international_filter_id)->delete();
		} catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
        }
	}

	public function deleteInternationalFilter(Request $request){
		$request->validate([
			'international_filter_id' => 'required'
		]);
		$international_filter = InternationalFilter::where('international_filter_id', $request->international_filter_id)->first();
		$this->deleteAssociations($international_filter);
		$international_filter->delete();
	}
}
