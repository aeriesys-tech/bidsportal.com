<?php

namespace App\Http\Controllers;
use App\Models\FederalFilter;
use App\Models\FederalFilterKeyword;
use App\Models\FederalFilterNotice;
use App\Models\FederalFilterStatus;
use App\Models\FederalFilterNaics;
use App\Models\FederalFilterPsc;
use App\Models\FederalFilterState;
use App\Models\FederalFilterSetAside;
use App\Models\FederalFilterAgency;
use App\Http\Resources\FederalFilterResource;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class FederalFilterController extends Controller
{
	public function getFederalFilters(Request $request)
    {
    	$data = $request->validate([
    		'user_id' => 'required'
    	]);
	    $federal_filters = FederalFilter::where('user_id', $request->user_id)->get();
	    return FederalFilterResource::collection($federal_filters);
	}

	public function updateFederalFilters(Request $request)
	{
	    $data = $request->validate([
	    	'federal_filter_id' => 'required|exists:federal_filters',
	    	'user_id' => 'required',
	        'federal_filter_name' => [
            'required',
	            Rule::unique('federal_filters')->where(function ($query) use ($request) {
	                return $query->where('user_id', $request->user_id);
	            })->ignore($request->federal_filter_id, 'federal_filter_id'),
	        ],
	        'posted_date' => 'sometimes|nullable',
	        'posted_from_date' => 'sometimes|nullable',
	        'posted_to_date' => 'sometimes|nullable',
	        'response_date' => 'sometimes|nullable',
	        'response_from_date' => 'sometimes|nullable',
	        'response_to_date' => 'sometimes|nullable',
	        'federal_notices' => 'sometimes|nullable|array',
	        'states' => 'sometimes|nullable|array',
	        'categories' => 'sometimes|nullable|array',
	        'federal_agencies' => 'sometimes|nullable|array',
	        'keywords' => 'sometimes|nullable|array', 
	        'statuses' => 'sometimes|nullable|array'
	    ]);

	    $federal_filter = FederalFilter::where('federal_filter_id', $request->federal_filter_id)->first();
	    if($federal_filter){
	    	FederalFilter::where('federal_filter_id', $request->federal_filter_id)->update([
	            'user_id' => $request->user_id,
			    'federal_filter_name' => $request->federal_filter_name,
			    'posted_date' => $request->posted_date ?: null,
			    'active' => $request->active ?: null,
			    'expired' => $request->expired ?: null,
			    'posted_from_date' => $request->posted_from_date ?: null,
			    'posted_to_date' => $request->posted_to_date ?: null,
			    'response_date' => $request->response_date ?: null,
			    'response_from_date' => $request->response_from_date ?: null,
			    'response_to_date' => $request->response_to_date ?: null
	        ]);
	        $this->deleteAssociations($federal_filter);
	        
	       	if ($request->has('keywords')) {
	            foreach ($request->keywords as $keyword) {
	                FederalFilterKeyword::updateOrCreate(
	                    ['federal_filter_id' => $federal_filter->federal_filter_id, 'keyword' => $keyword]
	                );
	            }
	        }

	        if ($request->has('federal_notices')) {
	            foreach ($request->federal_notices as $notice) {
	                FederalFilterNotice::updateOrCreate(
	                    ['federal_filter_id' => $federal_filter->federal_filter_id, 'federal_notice_id' => $notice]
	                );
	            }
	        }

	        if ($request->has('naics')) {
	            foreach ($request->naics as $naics) {
	                FederalFilterNaics::updateOrCreate(
	                    ['federal_filter_id' => $federal_filter->federal_filter_id, 'naics_id' => $naics]
	                );
	            }
	        }

	        if ($request->has('pscs')) {
	        	$filtered_psc_codes = array_filter($request->pscs, function($item) {
				    return is_numeric($item);
				});
				$filtered_psc_codes = array_values($filtered_psc_codes);
	            foreach ($filtered_psc_codes as $psc) {
	                FederalFilterPsc::updateOrCreate(
	                    ['federal_filter_id' => $federal_filter->federal_filter_id, 'psc_id' => $psc]
	                );
	            }
	        }

	        if ($request->has('states')) {
	            foreach ($request->states as $state) {
	                FederalFilterState::updateOrCreate(
	                    ['federal_filter_id' => $federal_filter->federal_filter_id, 'state_id' => $state]
	                );
	            }
	        }

	        if ($request->has('set_asides')) {
	            foreach ($request->set_asides as $set_aside) {
	                FederalFilterSetAside::updateOrCreate(
	                    ['federal_filter_id' => $federal_filter->federal_filter_id, 'set_aside_id' => $set_aside]
	                );
	            }
	        }

	        if ($request->has('federal_agencies')) {
	            foreach ($request->federal_agencies as $agency) {
	                FederalFilterAgency::updateOrCreate(
	                    ['federal_filter_id' => $federal_filter->federal_filter_id, 'federal_agency_id' => $agency]
	                );
	            }
	        }

	        return $federal_filter;
		}else{
			return response()->json(['errors' => 'No records found'], 422);
		}
        
	}

	public function addFederalFilters(Request $request)
	{
		$data = $request->validate([
	    	'user_id' => 'required',
	        'federal_filter_name' => [
	            'required',
	            Rule::unique('federal_filters')->where(function ($query) use ($request) {
	                return $query->where('user_id', $request->user_id);
	            }),
	        ],
	        'posted_date' => 'sometimes|nullable',
	        'posted_from_date' => 'sometimes|nullable',
	        'posted_to_date' => 'sometimes|nullable',
	        'response_date' => 'sometimes|nullable',
	        'response_from_date' => 'sometimes|nullable',
	        'response_to_date' => 'sometimes|nullable',
	        'federal_notices' => 'sometimes|nullable|array',
	        'states' => 'sometimes|nullable|array',
	        'categories' => 'sometimes|nullable|array',
	        'federal_agencies' => 'sometimes|nullable|array',
	        'keywords' => 'sometimes|nullable|array', 
	        'statuses' => 'sometimes|nullable|array'
	    ]);

	    
	   	$federal_filter = FederalFilter::whereHas('FederalFilterKeywords', function($que) use($request){
	        	$que->whereIn('keyword', $request->keywords);
	        })->where('user_id', $request->user_id)->first();

        if($federal_filter){
        	return response()->json(['message' => 'Same filter already exists'], 422);

        }else{
        	$federal_filter = FederalFilter::create([
	            'user_id' => $request->user_id,
			    'federal_filter_name' => $request->federal_filter_name,
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
	                FederalFilterKeyword::updateOrCreate(
	                    ['federal_filter_id' => $federal_filter->federal_filter_id, 'keyword' => $keyword]
	                );
	            }
	        }

	        if ($request->has('federal_notices')) {
	            foreach ($request->federal_notices as $notice) {
	                FederalFilterNotice::updateOrCreate(
	                    ['federal_filter_id' => $federal_filter->federal_filter_id, 'federal_notice_id' => $notice]
	                );
	            }
	        }

	        if ($request->has('naics')) {
	            foreach ($request->naics as $naics) {
	                FederalFilterNaics::updateOrCreate(
	                    ['federal_filter_id' => $federal_filter->federal_filter_id, 'naics_id' => $naics]
	                );
	            }
	        }

	        if ($request->has('pscs')) {
	        	$filtered_psc_codes = array_filter($request->pscs, function($item) {
				    return is_numeric($item);
				});
				$filtered_psc_codes = array_values($filtered_psc_codes);
	            foreach ($filtered_psc_codes as $psc) {
	                FederalFilterPsc::updateOrCreate(
	                    ['federal_filter_id' => $federal_filter->federal_filter_id, 'psc_id' => $psc]
	                );
	            }
	        }

	        if ($request->has('states')) {
	            foreach ($request->states as $state) {
	                FederalFilterState::updateOrCreate(
	                    ['federal_filter_id' => $federal_filter->federal_filter_id, 'state_id' => $state]
	                );
	            }
	        }

	        if ($request->has('set_asides')) {
	            foreach ($request->set_asides as $set_aside) {
	                FederalFilterSetAside::updateOrCreate(
	                    ['federal_filter_id' => $federal_filter->federal_filter_id, 'set_aside_id' => $set_aside]
	                );
	            }
	        }

	        if ($request->has('federal_agencies')) {
	            foreach ($request->federal_agencies as $agency) {
	                FederalFilterAgency::updateOrCreate(
	                    ['federal_filter_id' => $federal_filter->federal_filter_id, 'federal_agency_id' => $agency]
	                );
	            }
	        }

	        return $federal_filter;
        }
	}

	private function deleteAssociations($federal_filter)
	{
	    // Delete all existing associated records for this federal_filter
	    try{

		    FederalFilterKeyword::where('federal_filter_id', $federal_filter->federal_filter_id)->delete();
		    FederalFilterStatus::where('federal_filter_id', $federal_filter->federal_filter_id)->delete();
		    FederalFilterNotice::where('federal_filter_id', $federal_filter->federal_filter_id)->delete();
		    FederalFilterNaics::where('federal_filter_id', $federal_filter->federal_filter_id)->delete();
		    FederalFilterPsc::where('federal_filter_id', $federal_filter->federal_filter_id)->delete();
		    FederalFilterState::where('federal_filter_id', $federal_filter->federal_filter_id)->delete();
		    FederalFilterSetAside::where('federal_filter_id', $federal_filter->federal_filter_id)->delete();
		    FederalFilterAgency::where('federal_filter_id', $federal_filter->federal_filter_id)->delete();
		} catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
        }
	}

	public function deleteFederalFilter(Request $request){
		$request->validate([
			'federal_filter_id' => 'required'
		]);
		$federal_filter = FederalFilter::where('federal_filter_id', $request->federal_filter_id)->first();
		DB::statement('SET FOREIGN_KEY_CHECKS=0;'); 
		$this->deleteAssociations($federal_filter);
		$federal_filter->delete();
		DB::statement('SET FOREIGN_KEY_CHECKS=1;'); 
	}

}
