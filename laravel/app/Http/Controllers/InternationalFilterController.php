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
use Illuminate\Validation\Rule;

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
	    	'user_id' => 'required',
	        'international_filter_name' => [
            'required',
	            Rule::unique('international_filters')->where(function ($query) use ($request) {
	                return $query->where('user_id', $request->user_id);
	            })->ignore($request->international_filter_id, 'international_filter_id'),
	        ],
	        'posted_date' => 'sometimes|nullable',
	        'posted_from_date' => 'sometimes|nullable',
	        'posted_to_date' => 'sometimes|nullable',
	        'response_date' => 'sometimes|nullable',
	        'response_from_date' => 'sometimes|nullable',
	        'response_to_date' => 'sometimes|nullable',
	        'international_notices' => 'sometimes|nullable|array',
	        'states' => 'sometimes|nullable|array',
	        'categories' => 'sometimes|nullable|array',
	        'international_agencies' => 'sometimes|nullable|array',
	        'keywords' => 'sometimes|nullable|array', 
	        'statuses' => 'sometimes|nullable|array'
	    ]);
	    $international_filter = InternationalFilter::whereHas('InternationalFilterKeywords', function($que) use($request){
		        	$que->whereIn('keyword', $request->keywords);
		        })->where('user_id', $request->user_id)->first();
	    if($international_filter){
	    	return response()->json(['errors' => 'Same filter already exists'], 422);
	    }else{
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
	    }

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
	}

	public function updateInternationalFilters(Request $request)
	{
	    $data = $request->validate([
	    	'international_filter_id' => 'required|exists:international_filters',
	    	'user_id' => 'required',
	        'international_filter_name' => [
            'required',
	            Rule::unique('international_filters')->where(function ($query) use ($request) {
	                return $query->where('user_id', $request->user_id);
	            })->ignore($request->international_filter_id, 'international_filter_id'),
	        ],
	        'posted_date' => 'sometimes|nullable',
	        'posted_from_date' => 'sometimes|nullable',
	        'posted_to_date' => 'sometimes|nullable',
	        'response_date' => 'sometimes|nullable',
	        'response_from_date' => 'sometimes|nullable',
	        'response_to_date' => 'sometimes|nullable',
	        'international_notices' => 'sometimes|nullable|array',
	        'states' => 'sometimes|nullable|array',
	        'categories' => 'sometimes|nullable|array',
	        'international_agencies' => 'sometimes|nullable|array',
	        'keywords' => 'sometimes|nullable|array', 
	        'statuses' => 'sometimes|nullable|array'
	    ]);

	    $international_filter = InternationalFilter::where('international_filter_id', $request->international_filter_id)->first();
	    if($international_filter){
	    	InternationalFilter::where('international_filter_id', $request->state_filter_id)->update([
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
	        $this->deleteAssociations($international_filter);
	        if ($request->has('keywords')) {
	            foreach ($request->keywords as $keyword) {
	                InternationalFilterKeyword::updateOrCreate(
	                    ['international_filter_id' => $international_filter->international_filter_id, 'keyword' => $keyword]
	                );
	            }
	        }

	        if ($request->has('international_notices')) {
	            foreach ($request->international_notices as $notice) {
	                InternationalFilterNotice::updateOrCreate(
	                    ['international_filter_id' => $international_filter->international_filter_id, 'international_notice_id' => $notice]
	                );
	            }
	        }

	        if ($request->has('states')) {
	            foreach ($request->states as $state) {
	                InternationalFilterState::updateOrCreate(
	                    ['state_filter_id' => $state_filter->state_filter_id, 'state_id' => $state]
	                );
	            }
	        }

	        if ($request->has('international_agencies')) {
	            foreach ($request->international_agencies as $agency) {
	                InternationalFilterAgency::updateOrCreate(
	                    ['international_filter_id' => $international_filter->international_filter_id, 'international_agency_id' => $agency]
	                );
	            }
	        }
	        return $international_filter;
		}else{
			return response()->json(['errors' => 'No records found'], 422);
		}
        
	}

	private function deleteAssociations($international_filter)
	{
	    try{
		    InternationalFilterKeyword::where('international_filter_id', $international_filter->international_filter_id)->delete();
		    InternationalFilterNotice::where('international_filter_id', $international_filter->international_filter_id)->delete();
		    InternationalFilterState::where('international_filter_id', $international_filter->international_filter_id)->delete();
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
