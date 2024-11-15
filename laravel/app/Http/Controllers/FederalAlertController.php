<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FederalAlert;
use App\Models\FederalAlertKeyword;
use App\Models\FederalAlertNotice;
use App\Models\FederalAlertStatus;
use App\Models\FederalAlertNaics;
use App\Models\FederalAlertPsc;
use App\Models\FederalAlertState;
use App\Models\FederalAlertSetAside;
use App\Models\FederalAlertAgency;
use App\Http\Resources\FederalAlertResource;
use Auth;

class FederalAlertController extends Controller
{
	public function getFederalAlerts(Request $request){
		$user = Auth::User(); 
		$federal_alerts = FederalAlert::where('user_id', $user->user_id)->get();
		return $federal_alerts;	
	}

	public function paginateFederalAlerts(Request $request){
		$request->validate([
            'order_by' => 'required',
            'per_page' => 'required|numeric'
        ]);
        $user = Auth::User(); 
    	$query = FederalAlert::query();
    	$query->where('user_id', $user->user_id);
    	$query->orderBy('federal_alert_id', 'DESC');
    	$federal_alerts = $query->paginate($request->per_page);
        return FederalAlertResource::collection($federal_alerts);	
	}

	public function addFederalAlerts(Request $request)
	{
	    $user = Auth::User(); 
	    $data = $request->validate([
	        'federal_alert_name' => 'required',
	        'frequency' => 'required',
	        'posted_date' => 'sometimes|nullable',
	        'posted_from_date' => 'sometimes|nullable',
	        'posted_to_date' => 'sometimes|nullable',
	        'response_date' => 'sometimes|nullable',
	        'response_from_date' => 'sometimes|nullable',
	        'response_to_date' => 'sometimes|nullable',
	        'federal_notices' => 'sometimes|nullable|array',
	        'states' => 'sometimes|nullable|array',
	        'naics' => 'sometimes|nullable|array',
	        'pscs' => 'sometimes|nullable|array',
	        'set_asides' => 'sometimes|nullable|array',
	        'federal_agencies' => 'sometimes|nullable|array',
	        'keywords' => 'sometimes|nullable|array', 
	        'statuses' => 'sometimes|nullable|array'
	    ]);

	    if ($user) {

	    	try{
		        $federal_alert = FederalAlert::whereHas('FederalAlertKeywords', function($que) use($request){
		        	$que->whereIn('keyword', $request->keywords);
		        })->where('user_id', $user->user_id)->first();
	 
		        if (!$federal_alert){
			        $federal_alert = FederalAlert::create([
			            'user_id' => $user->user_id,
					    'federal_alert_name' => $request->federal_alert_name,
					    'frequency' => $request->frequency,
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
	                $this->deleteAssociations($federal_alert);
	            }

		        // Handle the related data associations
		        if ($request->has('keywords')) {
		            foreach ($request->keywords as $keyword) {
		                FederalAlertKeyword::updateOrCreate(
		                    ['federal_alert_id' => $federal_alert->federal_alert_id, 'keyword' => $keyword]
		                );
		            }
		        }

		        if ($request->has('federal_notices')) {
		            foreach ($request->federal_notices as $notice) {
		                FederalAlertNotice::updateOrCreate(
		                    ['federal_alert_id' => $federal_alert->federal_alert_id, 'federal_notice_id' => $notice]
		                );
		            }
		        }

		        if ($request->has('naics')) {
		            foreach ($request->naics as $naics) {
		                FederalAlertNaics::updateOrCreate(
		                    ['federal_alert_id' => $federal_alert->federal_alert_id, 'naics_id' => $naics]
		                );
		            }
		        }

		        if ($request->has('pscs')) {
		        	$filtered_psc_codes = array_filter($request->pscs, function($item) {
					    return is_numeric($item);
					});
					$filtered_psc_codes = array_values($filtered_psc_codes);
		            foreach ($filtered_psc_codes as $psc) {
		                FederalAlertPsc::updateOrCreate(
		                    ['federal_alert_id' => $federal_alert->federal_alert_id, 'psc_id' => $psc]
		                );
		            }
		        }

		        if ($request->has('states')) {
		            foreach ($request->states as $state) {
		                FederalAlertState::updateOrCreate(
		                    ['federal_alert_id' => $federal_alert->federal_alert_id, 'state_id' => $state]
		                );
		            }
		        }

		        if ($request->has('set_asides')) {
		            foreach ($request->set_asides as $set_aside) {
		                FederalAlertSetAside::updateOrCreate(
		                    ['federal_alert_id' => $federal_alert->federal_alert_id, 'set_aside_id' => $set_aside]
		                );
		            }
		        }

		        if ($request->has('federal_agencies')) {
		            foreach ($request->federal_agencies as $agency) {
		                FederalAlertAgency::updateOrCreate(
		                    ['federal_alert_id' => $federal_alert->federal_alert_id, 'federal_agency_id' => $agency]
		                );
		            }
		        }

		        return $federal_alert;
		    } catch (\Exception $e) {
	            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
	        }
	    }
	}
}
