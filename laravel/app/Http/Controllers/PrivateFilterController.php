<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PrivateFilter;
use App\Models\PrivateFilterKeyword;
use App\Models\PrivateFilterNotice;
use App\Models\PrivateFilterState;
use App\Models\PrivateFilterSetAside;
use App\Models\PrivateFilterAgency;
use App\Http\Resources\PrivateFilterResource;
use Auth;
use Illuminate\Validation\Rule;

class PrivateFilterController extends Controller
{
    public function getPrivateFilters(Request $request)
    {
    	$data = $request->validate([
    		'user_id' => 'required'
    	]);
	    $private_filters = PrivateFilter::where('user_id', $request->user_id)->get();
	    return PrivateFilterResource::collection($private_filters);
		
	}

	public function addPrivateFilters(Request $request)
	{
	    $data = $request->validate([
	    	'user_id' => 'required',
	        'private_filter_name' => [
	            'required',
	            Rule::unique('private_filters')->where(function ($query) use ($request) {
	                return $query->where('user_id', $request->user_id);
	            }),
	        ],
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

	    $private_filter = PrivateFilter::whereHas('PrivateFilterKeywords', function($que) use($request){
        	$que->whereIn('keyword', $request->keywords);
        })->where('user_id', $request->user_id)->first();

        if($private_filter){
        	return response()->json(['message' => 'Same filter already exists'], 422);

        }else{
        	$private_filter = PrivateFilter::create([
	            'user_id' => $request->user_id,
			    'private_filter_name' => $request->private_filter_name,
			    'posted_date' => $request->posted_date ?: null,
			    'active' => $request->active ?: null,
			    'expired' => $request->expired ?: null,
			    'posted_from_date' => $request->posted_from_date ?: null,
			    'posted_to_date' => $request->posted_to_date ?: null,
			    'response_date' => $request->response_date ?: null,
			    'response_from_date' => $request->response_from_date ?: null,
			    'response_to_date' => $request->response_to_date ?: null
	        ]);

	        if ($request->has('keywords')) {
	            foreach ($request->keywords as $keyword) {
	                PrivateFilterKeyword::updateOrCreate(
	                    ['private_filter_id' => $private_filter->private_filter_id, 'keyword' => $keyword]
	                );
	            }
	        }

	        if ($request->has('state_notices')) {
	            foreach ($request->state_notices as $notice) {
	                PrivateFilterNotice::updateOrCreate(
	                    ['private_filter_id' => $private_filter->private_filter_id, 'state_notice_id' => $notice]
	                );
	            }
	        }

	        if ($request->has('states')) {
	            foreach ($request->states as $state) {
	                PrivateFilterState::updateOrCreate(
	                    ['private_filter_id' => $private_filter->private_filter_id, 'state_id' => $state]
	                );
	            }
	        }

	        if ($request->has('state_agencies')) {
	            foreach ($request->state_agencies as $agency) {
	                PrivateFilterAgency::updateOrCreate(
	                    ['private_filter_id' => $private_filter->private_filter_id, 'state_agency_id' => $agency]
	                );
	            }
	        }
	        return $private_filter;
        }
	}

	public function updatePrivateFilters(Request $request)
	{
	    $data = $request->validate([
	    	'private_filter_id' => 'required|exists:private_filters',
	    	'user_id' => 'required',
	        'private_filter_name' => [
            'required',
	            Rule::unique('private_filters')->where(function ($query) use ($request) {
	                return $query->where('user_id', $request->user_id);
	            })->ignore($request->private_filter_id, 'private_filter_id'),
	        ],
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

	    $private_filter = PrivateFilter::where('private_filter_id', $request->private_filter_id)->first();
	    if($private_filter){
	    	PrivateFilter::where('private_filter_id', $request->private_filter_id)->update([
	            'user_id' => $request->user_id,
			    'private_filter_name' => $request->private_filter_name,
			    'posted_date' => $request->posted_date ?: null,
			    'active' => $request->active ?: null,
			    'expired' => $request->expired ?: null,
			    'posted_from_date' => $request->posted_from_date ?: null,
			    'posted_to_date' => $request->posted_to_date ?: null,
			    'response_date' => $request->response_date ?: null,
			    'response_from_date' => $request->response_from_date ?: null,
			    'response_to_date' => $request->response_to_date ?: null
	        ]);
	        $this->deleteAssociations($private_filter);
	        if ($request->has('keywords')) {
	            foreach ($request->keywords as $keyword) {
	                PrivateFilterKeyword::updateOrCreate(
	                    ['private_filter_id' => $private_filter->private_filter_id, 'keyword' => $keyword]
	                );
	            }
	        }

	        if ($request->has('state_notices')) {
	            foreach ($request->state_notices as $notice) {
	                PrivateFilterNotice::updateOrCreate(
	                    ['private_filter_id' => $private_filter->private_filter_id, 'state_notice_id' => $notice]
	                );
	            }
	        }

	        if ($request->has('states')) {
	            foreach ($request->states as $state) {
	                PrivateFilterState::updateOrCreate(
	                    ['private_filter_id' => $private_filter->private_filter_id, 'state_id' => $state]
	                );
	            }
	        }

	        if ($request->has('state_agencies')) {
	            foreach ($request->state_agencies as $agency) {
	                PrivateFilterAgency::updateOrCreate(
	                    ['private_filter_id' => $private_filter->private_filter_id, 'state_agency_id' => $agency]
	                );
	            }
	        }
	        return $private_filter;
		}else{
			return response()->json(['errors' => 'No records found'], 422);
		}
        
	}

    public function addPrivateFilters2(Request $request)
	{
    	$data = $request->validate([
    		'user_id' => 'required'
    	]);

	    $data = $request->validate([
	        'private_filter_name' => 'required',
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
		        $private_filter = PrivateFilter::whereHas('PrivateFilterKeywords', function($que) use($request){
		        	$que->whereIn('keyword', $request->keywords);
		        })->where('user_id', $request->user_id)->first();
	 
		        if (!$private_filter){
			        $private_filter = PrivateFilter::create([
			            'user_id' => $request->user_id,
					    'private_filter_name' => $request->private_filter_name,
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
	                $this->deleteAssociations($private_filter);
	            }

		        // Handle the related data associations
		        if ($request->has('keywords')) {
		            foreach ($request->keywords as $keyword) {
		                PrivateFilterKeyword::updateOrCreate(
		                    ['private_filter_id' => $private_filter->private_filter_id, 'keyword' => $keyword]
		                );
		            }
		        }

		        if ($request->has('state_notices')) {
		            foreach ($request->state_notices as $notice) {
		                PrivateFilterNotice::updateOrCreate(
		                    ['private_filter_id' => $private_filter->private_filter_id, 'state_notice_id' => $notice]
		                );
		            }
		        }

		        if ($request->has('states')) {
		            foreach ($request->states as $state) {
		                PrivateFilterState::updateOrCreate(
		                    ['private_filter_id' => $private_filter->private_filter_id, 'state_id' => $state]
		                );
		            }
		        }

		        if ($request->has('state_agencies')) {
		            foreach ($request->state_agencies as $agency) {
		                PrivateFilterAgency::updateOrCreate(
		                    ['private_filter_id' => $private_filter->private_filter_id, 'state_agency_id' => $agency]
		                );
		            }
		        }

		        return $private_filter;
		    } catch (\Exception $e) {
	            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
	        }
	}

	private function deleteAssociations($private_filter)
	{
	    try{
		    PrivateFilterKeyword::where('private_filter_id', $private_filter->private_filter_id)->delete();
		    PrivateFilterNotice::where('private_filter_id', $private_filter->private_filter_id)->delete();
		    PrivateFilterState::where('private_filter_id', $private_filter->private_filter_id)->delete();
		    PrivateFilterAgency::where('private_filter_id', $private_filter->private_filter_id)->delete();
		} catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
        }
	}

	public function deletePrivateFilter(Request $request){
		$request->validate([
			'private_filter_id' => 'required'
		]);
		$private_filter = PrivateFilter::where('private_filter_id', $request->private_filter_id)->first();
		$this->deleteAssociations($private_filter);
		$private_filter->delete();
	}
}
