<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alert;
use App\Models\AlertKeyword;
use App\Models\FederalAlertNotice;
use App\Models\AlertNaics;
use App\Models\AlertPsc;
use App\Models\AlertState;
use App\Models\AlertSetAside;
use App\Models\FederalAlertAgency;
use App\Models\AlertCategory;
use App\Models\StateAlertNotice;
use App\Models\StateAlertAgency;
use App\Models\PrivateAlertNotice;
use App\Models\PrivateAlertAgency;
use App\Models\InternationalAlertNotice;
use App\Models\InternationalAlertAgency;

use App\Http\Resources\AlertResource;
use App\Http\Resources\AlertPaginateResource;
use Auth;

class AlertController extends Controller
{
    public function getAlert(Request $request){ 
		$alert = Alert::where('alert_id', $request->alert_id)->first();
		return new AlertResource($alert);	
	}

	public function deleteAlert(Request $request){ 
		$this->deleteAssociations($request);
		return Alert::where('alert_id', $request->alert_id)->delete();
	}


	public function paginateAlerts(Request $request){
		$request->validate([
            'order_by' => 'required',
            'per_page' => 'required|numeric'
        ]);
    	$query = Alert::query();
    	if($request->user_id){
	    	$query->where('user_id', $request->user_id);
	    }

	    if($request->search){
	    	$query->where('alert_title', 'like', "%$request->search%")->orWhere('region', 'like', "%$request->search%")->orWhere('frequency', 'like', "%$request->search%")->orWhereHas('User', function($que) use($request){
	    		$que->where('name', 'like', "%$request->search%");
	    	});

	    }
    	$query->orderBy('alert_id', 'DESC');
    	$alerts = $query->paginate($request->per_page);
        return AlertPaginateResource::collection($alerts);
	}

	public function addAlerts(Request $request)
	{
	    $data = $request->validate([
	    	'user_id' => 'required',
	        'alert_title' => 'required',
	        'frequency' => 'required',
	        'region' => 'required',
	        'posted_date' => 'sometimes|nullable',
	        'posted_from_date' => 'sometimes|nullable',
	        'posted_to_date' => 'sometimes|nullable',
	        'response_date' => 'sometimes|nullable',
	        'response_from_date' => 'sometimes|nullable',
	        'response_to_date' => 'sometimes|nullable',
	        'federal_notices' => 'required|array',
	        'states' => 'required|array',
	        'naics' => 'required|array',
	        'pscs' => 'required|array',
	        'set_asides' => 'required|array',
	        'federal_agencies' => 'sometimes|nullable|array',
	        'keywords' => 'required|array', 
	        'statuses' => 'sometimes|nullable|array'
	    ]);
    	try{
	        $alert = Alert::whereHas('AlertKeywords', function($que) use($request){
	        	$que->whereIn('keyword', $request->keywords);
	        })->where('user_id', $request->user_id)->first();
 
	        if (!$alert){
		        $alert = Alert::create([
		            'user_id' => $request->user_id,
				    'alert_title' => $request->alert_title,
				    'region' => $request->region,
				    'frequency' => $request->frequency,
				    'posted_date' => $request->posted_date ?: null,
				    'active' => $request->active ?: null,
				    'expired' => $request->expired ?: null,
				    'posted_from_date' => $request->posted_from_date ?: null,
				    'posted_to_date' => $request->posted_to_date ?: null,
				    'response_date' => $request->response_date ?: null,
				    'response_from_date' => $request->response_from_date ?: null,
				    'response_to_date' => $request->response_to_date ?: null,
				    'status' => true
		        ]);
		    }else {
                // Delete previous associations if the filter already exists
                $this->deleteAssociations($alert);
            }

	        // Handle the related data associations
	        if ($request->has('keywords')) {
	            foreach ($request->keywords as $keyword) {
	                AlertKeyword::updateOrCreate(
	                    ['alert_id' => $alert->alert_id, 'keyword' => $keyword]
	                );
	            }
	        }

	        if ($request->has('federal_notices')) {
	            foreach ($request->federal_notices as $notice) {
	                FederalAlertNotice::updateOrCreate(
	                    ['alert_id' => $alert->alert_id, 'federal_notice_id' => $notice]
	                );
	            }
	        }

	        if ($request->has('naics')) {
	            foreach ($request->naics as $naics) {
	                AlertNaics::updateOrCreate(
	                    ['alert_id' => $alert->alert_id, 'naics_id' => $naics]
	                );
	            }
	        }

	        if ($request->has('pscs')) {
	        	$filtered_psc_codes = array_filter($request->pscs, function($item) {
				    return is_numeric($item);
				});
				$filtered_psc_codes = array_values($filtered_psc_codes);
	            foreach ($filtered_psc_codes as $psc) {
	                AlertPsc::updateOrCreate(
	                    ['alert_id' => $alert->alert_id, 'psc_id' => $psc]
	                );
	            }
	        }

	        if ($request->has('states')) {
	            foreach ($request->states as $state) {
	                AlertState::updateOrCreate(
	                    ['alert_id' => $alert->alert_id, 'state_id' => $state]
	                );
	            }
	        }

	        if ($request->has('set_asides')) {
	            foreach ($request->set_asides as $set_aside) {
	                AlertSetAside::updateOrCreate(
	                    ['alert_id' => $alert->alert_id, 'set_aside_id' => $set_aside]
	                );
	            }
	        }

	        if ($request->has('federal_agencies')) {
	            foreach ($request->federal_agencies as $agency) {
	                FederalAlertAgency::updateOrCreate(
	                    ['alert_id' => $alert->alert_id, 'federal_agency_id' => $agency]
	                );
	            }
	        }

	        if ($request->has('categories')) {
	            foreach ($request->categories as $category) {
	                AlertCategory::updateOrCreate(
	                    ['alert_id' => $alert->alert_id, 'category_id' => $category]
	                );
	            }
	        }

	        if ($request->has('state_notices')) {
	            foreach ($request->state_notices as $notice) {
	                StateAlertNotice::updateOrCreate(
	                    ['alert_id' => $alert->alert_id, 'state_notice_id' => $notice]
	                );
	            }
	        }

	        if ($request->has('state_agencies')) {
	            foreach ($request->state_agencies as $agency) {
	                StateAlertAgency::updateOrCreate(
	                    ['alert_id' => $alert->alert_id, 'state_agency_id' => $agency]
	                );
	            }
	        }

	        return $alert;
	    } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
        }
	}

	public function addStateAlerts(Request $request)
	{
	    $data = $request->validate([
	    	'user_id' => 'required',
	        'alert_title' => 'required',
	        'frequency' => 'required',
	        'region' => 'required',
	        'posted_date' => 'sometimes|nullable',
	        'posted_from_date' => 'sometimes|nullable',
	        'posted_to_date' => 'sometimes|nullable',
	        'response_date' => 'sometimes|nullable',
	        'response_from_date' => 'sometimes|nullable',
	        'response_to_date' => 'sometimes|nullable',
	        'state_notices' => 'required|array',
	        'states' => 'required|array',
	        'categories' => 'sometimes|nullable|array',
	        'state_agencies' => 'sometimes|nullable|array',
	        'keywords' => 'required|array', 
	        'statuses' => 'sometimes|nullable|array'
	    ]);
    	try{
	        $alert = Alert::whereHas('AlertKeywords', function($que) use($request){
	        	$que->whereIn('keyword', $request->keywords);
	        })->where('user_id', $request->user_id)->first();
 
	        if (!$alert){
		        $alert = Alert::create([
		            'user_id' => $request->user_id,
				    'alert_title' => $request->alert_title,
				    'region' => $request->region,
				    'frequency' => $request->frequency,
				    'posted_date' => $request->posted_date ?: null,
				    'active' => $request->active ?: null,
				    'expired' => $request->expired ?: null,
				    'posted_from_date' => $request->posted_from_date ?: null,
				    'posted_to_date' => $request->posted_to_date ?: null,
				    'response_date' => $request->response_date ?: null,
				    'response_from_date' => $request->response_from_date ?: null,
				    'response_to_date' => $request->response_to_date ?: null,
				    'status' => true
		        ]);
		    }else {
                // Delete previous associations if the filter already exists
                $this->deleteStateAssociations($alert);
            }

	        // Handle the related data associations
	        if ($request->has('keywords')) {
	            foreach ($request->keywords as $keyword) {
	                AlertKeyword::updateOrCreate(
	                    ['alert_id' => $alert->alert_id, 'keyword' => $keyword]
	                );
	            }
	        }

	        if ($request->has('states')) {
	            foreach ($request->states as $state) {
	                AlertState::updateOrCreate(
	                    ['alert_id' => $alert->alert_id, 'state_id' => $state]
	                );
	            }
	        }

	        if ($request->has('categories')) {
	            foreach ($request->categories as $category) {
	                AlertCategory::updateOrCreate(
	                    ['alert_id' => $alert->alert_id, 'category_id' => $category]
	                );
	            }
	        }

	        if ($request->has('state_notices')) {
	            foreach ($request->state_notices as $notice) {
	                StateAlertNotice::updateOrCreate(
	                    ['alert_id' => $alert->alert_id, 'state_notice_id' => $notice]
	                );
	            }
	        }

	        if ($request->has('state_agencies')) {
	            foreach ($request->state_agencies as $agency) {
	                StateAlertAgency::updateOrCreate(
	                    ['alert_id' => $alert->alert_id, 'state_agency_id' => $agency]
	                );
	            }
	        }

	        return $alert;
	    } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
        }
	}

	public function addPrivateAlerts(Request $request)
	{
	    $data = $request->validate([
	    	'user_id' => 'required',
	        'alert_title' => 'required',
	        'frequency' => 'required',
	        'region' => 'required',
	        'posted_date' => 'sometimes|nullable',
	        'posted_from_date' => 'sometimes|nullable',
	        'posted_to_date' => 'sometimes|nullable',
	        'response_date' => 'sometimes|nullable',
	        'response_from_date' => 'sometimes|nullable',
	        'response_to_date' => 'sometimes|nullable',
	        'private_notices' => 'required|array',
	        'states' => 'required|array',
	        'categories' => 'sometimes|nullable|array',
	        'private_agencies' => 'sometimes|nullable|array',
	        'keywords' => 'required|array', 
	        'statuses' => 'sometimes|nullable|array'
	    ]);
    	try{
	        $alert = Alert::whereHas('AlertKeywords', function($que) use($request){
	        	$que->whereIn('keyword', $request->keywords);
	        })->where('user_id', $request->user_id)->first();
 
	        if (!$alert){
		        $alert = Alert::create([
		            'user_id' => $request->user_id,
				    'alert_title' => $request->alert_title,
				    'region' => $request->region,
				    'frequency' => $request->frequency,
				    'posted_date' => $request->posted_date ?: null,
				    'active' => $request->active ?: null,
				    'expired' => $request->expired ?: null,
				    'posted_from_date' => $request->posted_from_date ?: null,
				    'posted_to_date' => $request->posted_to_date ?: null,
				    'response_date' => $request->response_date ?: null,
				    'response_from_date' => $request->response_from_date ?: null,
				    'response_to_date' => $request->response_to_date ?: null,
				    'status' => true
		        ]);
		    }else {
                // Delete previous associations if the filter already exists
                $this->deletePrivateAssociations($alert);
            }

	        // Handle the related data associations
	        if ($request->has('keywords')) {
	            foreach ($request->keywords as $keyword) {
	                AlertKeyword::updateOrCreate(
	                    ['alert_id' => $alert->alert_id, 'keyword' => $keyword]
	                );
	            }
	        }
	        
	        if ($request->has('states')) {
	            foreach ($request->states as $state) {
	                AlertState::updateOrCreate(
	                    ['alert_id' => $alert->alert_id, 'state_id' => $state]
	                );
	            }
	        }

	        if ($request->has('categories')) {
	            foreach ($request->categories as $category) {
	                AlertCategory::updateOrCreate(
	                    ['alert_id' => $alert->alert_id, 'category_id' => $category]
	                );
	            }
	        }

	        if ($request->has('private_notices')) {
	            foreach ($request->private_notices as $notice) {
	                PrivateAlertNotice::updateOrCreate(
	                    ['alert_id' => $alert->alert_id, 'private_notice_id' => $notice]
	                );
	            }
	        }

	        if ($request->has('private_agencies')) {
	            foreach ($request->private_agencies as $agency) {
	                PrivateAlertAgency::updateOrCreate(
	                    ['alert_id' => $alert->alert_id, 'private_agency_id' => $agency]
	                );
	            }
	        }

	        return $alert;
	    } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
        }
	}

	public function addInternationalAlerts(Request $request)
	{
	    $data = $request->validate([
	    	'user_id' => 'required',
	        'alert_title' => 'required',
	        'frequency' => 'required',
	        'region' => 'required',
	        'posted_date' => 'sometimes|nullable',
	        'posted_from_date' => 'sometimes|nullable',
	        'posted_to_date' => 'sometimes|nullable',
	        'response_date' => 'sometimes|nullable',
	        'response_from_date' => 'sometimes|nullable',
	        'response_to_date' => 'sometimes|nullable',
	        'international_notices' => 'required|array',
	        'states' => 'required|array',
	        'categories' => 'sometimes|nullable|array',
	        'international_agencies' => 'sometimes|nullable|array',
	        'keywords' => 'required|array', 
	        'statuses' => 'sometimes|nullable|array'
	    ]);
    	try{
	        $alert = Alert::whereHas('AlertKeywords', function($que) use($request){
	        	$que->whereIn('keyword', $request->keywords);
	        })->where('user_id', $request->user_id)->first();
 
	        if (!$alert){
		        $alert = Alert::create([
		            'user_id' => $request->user_id,
				    'alert_title' => $request->alert_title,
				    'region' => $request->region,
				    'frequency' => $request->frequency,
				    'posted_date' => $request->posted_date ?: null,
				    'active' => $request->active ?: null,
				    'expired' => $request->expired ?: null,
				    'posted_from_date' => $request->posted_from_date ?: null,
				    'posted_to_date' => $request->posted_to_date ?: null,
				    'response_date' => $request->response_date ?: null,
				    'response_from_date' => $request->response_from_date ?: null,
				    'response_to_date' => $request->response_to_date ?: null,
				    'status' => true
		        ]);
		    }else {
                // Delete previous associations if the filter already exists
                $this->deleteInternationalAssociations($alert);
            }

	        // Handle the related data associations
	        if ($request->has('keywords')) {
	            foreach ($request->keywords as $keyword) {
	                AlertKeyword::updateOrCreate(
	                    ['alert_id' => $alert->alert_id, 'keyword' => $keyword]
	                );
	            }
	        }
	        
	        if ($request->has('states')) {
	            foreach ($request->states as $state) {
	                AlertState::updateOrCreate(
	                    ['alert_id' => $alert->alert_id, 'state_id' => $state]
	                );
	            }
	        }

	        if ($request->has('categories')) {
	            foreach ($request->categories as $category) {
	                AlertCategory::updateOrCreate(
	                    ['alert_id' => $alert->alert_id, 'category_id' => $category]
	                );
	            }
	        }

	        if ($request->has('international_notices')) {
	            foreach ($request->international_notices as $notice) {
	                InternationalAlertNotice::updateOrCreate(
	                    ['alert_id' => $alert->alert_id, 'international_notice_id' => $notice]
	                );
	            }
	        }

	        if ($request->has('international_agencies')) {
	            foreach ($request->international_agencies as $agency) {
	                InternationalAlertAgency::updateOrCreate(
	                    ['alert_id' => $alert->alert_id, 'international_agency_id' => $agency]
	                );
	            }
	        }

	        return $alert;
	    } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
        }
	}

	public function createAlerts(Request $request)
	{

	    $data = $request->validate([
	    	'user_id' => 'required',
	        'alert_title' => 'required',
	        'frequency' => 'required',
	        'region' => 'required',
	        'posted_date' => 'sometimes|nullable',
	        'posted_from_date' => 'sometimes|nullable',
	        'posted_to_date' => 'sometimes|nullable',
	        'response_date' => 'sometimes|nullable',
	        'response_from_date' => 'sometimes|nullable',
	        'response_to_date' => 'sometimes|nullable',
	        'federal_notices' => 'required|array',
	        'states' => 'required|array',
	        'naics' => 'required|array',
	        'pscs' => 'required|array',
	        'set_asides' => 'required|array',
	        'federal_agencies' => 'sometimes|nullable|array',
	        'keywords' => 'required|array', 
	        'statuses' => 'sometimes|nullable|array'
	    ]);

	    	try{
		        $alert = Alert::whereHas('AlertKeywords', function($que) use($request){
		        	$que->whereIn('keyword', $request->keywords);
		        })->where('user_id', $request->user_id)->first();
	 			
		        if (!$alert){
			        $alert = Alert::create([
			            'user_id' => $request->user_id,
					    'alert_title' => $request->alert_title,
					    'region' => $request->region,
					    'frequency' => $request->frequency,
					    'posted_date' => $request->posted_date ?: null,
					    'active' => $request->active ?: null,
					    'expired' => $request->expired ?: null,
					    'posted_from_date' => $request->posted_from_date ?: null,
					    'posted_to_date' => $request->posted_to_date ?: null,
					    'response_date' => $request->response_date ?: null,
					    'response_from_date' => $request->response_from_date ?: null,
					    'response_to_date' => $request->response_to_date ?: null,
					    'status' => true
			        ]);
			    }else {
	                // Delete previous associations if the filter already exists
	                $this->deleteAssociations($alert);
	            }

		        // Handle the related data associations
		        if ($request->has('keywords')) {
		            foreach ($request->keywords as $keyword) {
		                AlertKeyword::updateOrCreate(
		                    ['alert_id' => $alert->alert_id, 'keyword' => $keyword]
		                );
		            }
		        }

		        if ($request->has('federal_notices')) {
		            foreach ($request->federal_notices as $notice) {
		                FederalAlertNotice::updateOrCreate(
		                    ['alert_id' => $alert->alert_id, 'federal_notice_id' => $notice]
		                );
		            }
		        }

		        if ($request->has('naics')) {
		            foreach ($request->naics as $naics) {
		                AlertNaics::updateOrCreate(
		                    ['alert_id' => $alert->alert_id, 'naics_id' => $naics]
		                );
		            }
		        }

		        if ($request->has('pscs')) {
		        	$filtered_psc_codes = array_filter($request->pscs, function($item) {
					    return is_numeric($item);
					});
					$filtered_psc_codes = array_values($filtered_psc_codes);
		            foreach ($filtered_psc_codes as $psc) {
		                AlertPsc::updateOrCreate(
		                    ['alert_id' => $alert->alert_id, 'psc_id' => $psc]
		                );
		            }
		        }

		        if ($request->has('states')) {
		            foreach ($request->states as $state) {
		                AlertState::updateOrCreate(
		                    ['alert_id' => $alert->alert_id, 'state_id' => $state]
		                );
		            }
		        }

		        if ($request->has('set_asides')) {
		            foreach ($request->set_asides as $set_aside) {
		                AlertSetAside::updateOrCreate(
		                    ['alert_id' => $alert->alert_id, 'set_aside_id' => $set_aside]
		                );
		            }
		        }

		        if ($request->has('federal_agencies')) {
		            foreach ($request->federal_agencies as $agency) {
		                FederalAlertAgency::updateOrCreate(
		                    ['alert_id' => $alert->alert_id, 'federal_agency_id' => $agency]
		                );
		            }
		        }

		        return $alert;
		    } catch (\Exception $e) {
	            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
	        }
	}

	public function updateAlerts(Request $request)
	{
	    $data = $request->validate([
	    	'user_id' => 'required',
	        'alert_title' => 'required',
	        'frequency' => 'required',
	        'region' => 'required',
	        'posted_date' => 'sometimes|nullable',
	        'posted_from_date' => 'sometimes|nullable',
	        'posted_to_date' => 'sometimes|nullable',
	        'response_date' => 'sometimes|nullable',
	        'response_from_date' => 'sometimes|nullable',
	        'response_to_date' => 'sometimes|nullable',
	        'federal_notices' => 'required|array',
	        'states' => 'required|array',
	        'naics' => 'required|array',
	        'pscs' => 'required|array',
	        'set_asides' => 'required|array',
	        'federal_agencies' => 'sometimes|nullable|array',
	        'keywords' => 'required|array', 
	        'statuses' => 'sometimes|nullable|array'
	    ]);

	    	// try{
	    		$alert = Alert::where('alert_id', $request->alert_id)->first();
	    		$alert->update([
		            'user_id' => $request->user_id,
				    'alert_title' => $request->alert_title,
				    'region' => $request->region,
				    'frequency' => $request->frequency,
				    'posted_date' => $request->posted_date ?: null,
				    'active' => $request->active ?: null,
				    'expired' => $request->expired ?: null,
				    'posted_from_date' => $request->posted_from_date ?: null,
				    'posted_to_date' => $request->posted_to_date ?: null,
				    'response_date' => $request->response_date ?: null,
				    'response_from_date' => $request->response_from_date ?: null,
				    'response_to_date' => $request->response_to_date ?: null,
				    'status' => true
		        ]);
		        $this->deleteAssociations($alert);

		        // Handle the related data associations
		        if ($request->has('keywords')) {
		            foreach ($request->keywords as $keyword) {
		                AlertKeyword::updateOrCreate(
		                    ['alert_id' => $alert->alert_id, 'keyword' => $keyword]
		                );
		            }
		        }

		        if ($request->has('federal_notices')) {
		            foreach ($request->federal_notices as $notice) {
		                FederalAlertNotice::updateOrCreate(
		                    ['alert_id' => $alert->alert_id, 'federal_notice_id' => $notice]
		                );
		            }
		        }

		        if ($request->has('naics')) {
		            foreach ($request->naics as $naics) {
		                AlertNaics::updateOrCreate(
		                    ['alert_id' => $alert->alert_id, 'naics_id' => $naics]
		                );
		            }
		        }

		        if ($request->has('pscs')) {
		        	$filtered_psc_codes = array_filter($request->pscs, function($item) {
					    return is_numeric($item);
					});
					$filtered_psc_codes = array_values($filtered_psc_codes);
		            foreach ($filtered_psc_codes as $psc) {
		                AlertPsc::updateOrCreate(
		                    ['alert_id' => $alert->alert_id, 'psc_id' => $psc]
		                );
		            }
		        }

		        if ($request->has('states')) {
		            foreach ($request->states as $state) {
		                AlertState::updateOrCreate(
		                    ['alert_id' => $alert->alert_id, 'state_id' => $state]
		                );
		            }
		        }

		        if ($request->has('set_asides')) {
		            foreach ($request->set_asides as $set_aside) {
		                AlertSetAside::updateOrCreate(
		                    ['alert_id' => $alert->alert_id, 'set_aside_id' => $set_aside]
		                );
		            }
		        }

		        if ($request->has('federal_agencies')) {
		            foreach ($request->federal_agencies as $agency) {
		                FederalAlertAgency::updateOrCreate(
		                    ['alert_id' => $alert->alert_id, 'federal_agency_id' => $agency]
		                );
		            }
		        }

		        return $alert;
		    // } catch (\Exception $e) {
	     //        return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
	     //    }
	}

	private function deleteAssociations($alert)
	{
	    // Delete all existing associated records for this alert
	    try{
		    AlertKeyword::where('alert_id', $alert->alert_id)->delete();
		    FederalAlertNotice::where('alert_id', $alert->alert_id)->delete();
		    AlertNaics::where('alert_id', $alert->alert_id)->delete();
		    AlertPsc::where('alert_id', $alert->alert_id)->delete();
		    AlertState::where('alert_id', $alert->alert_id)->delete();
		    AlertSetAside::where('alert_id', $alert->alert_id)->delete();
		    FederalAlertAgency::where('alert_id', $alert->alert_id)->delete();
		} catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
        }
	}

	private function deleteStateAssociations($alert)
	{
	    // Delete all existing associated records for this alert
	    try{
		    AlertKeyword::where('alert_id', $alert->alert_id)->delete();
		    StateAlertNotice::where('alert_id', $alert->alert_id)->delete();
		    AlertCategory::where('alert_id', $alert->alert_id)->delete();
		    AlertState::where('alert_id', $alert->alert_id)->delete();
		    StateAlertAgency::where('alert_id', $alert->alert_id)->delete();
		} catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
        }
	}

	private function deletePrivateAssociations($alert)
	{
	    // Delete all existing associated records for this alert
	    try{
		    AlertKeyword::where('alert_id', $alert->alert_id)->delete();
		    PrivateAlertNotice::where('alert_id', $alert->alert_id)->delete();
		    AlertCategory::where('alert_id', $alert->alert_id)->delete();
		    AlertState::where('alert_id', $alert->alert_id)->delete();
		    PrivateAlertAgency::where('alert_id', $alert->alert_id)->delete();
		} catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
        }
	}

	private function deleteInternationalAssociations($alert)
	{
	    // Delete all existing associated records for this alert
	    try{
		    AlertKeyword::where('alert_id', $alert->alert_id)->delete();
		    InternationalAlertNotice::where('alert_id', $alert->alert_id)->delete();
		    AlertCategory::where('alert_id', $alert->alert_id)->delete();
		    AlertState::where('alert_id', $alert->alert_id)->delete();
		    PrivateAlertAgency::where('alert_id', $alert->alert_id)->delete();
		} catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
        }
	}

	public function paginateAllAlerts(Request $request)
	{
		$request->validate([
			'order_by' => 'required',
			'per_page' => 'required|numeric',
			'keyword' => 'required'
		]);

		$query = Alert::query();
	    
		if($request->search!='')
		{
			$query->where('region', 'like', "%$request->search%")->orWhere('frequency', 'like', "$request->search%")
				->orWhere('alert_title', 'like', "%$request->search%")->orWhere('posted_date', 'like', "$request->search%")->orWhereHas('User', function($que) use($request){
					$que->where('name', 'like', "%$request->search%");
				});
		}
		$users = $query->orderBy($request->keyword,$request->order_by)->paginate($request->per_page);
		return AlertResource::collection($users);
	}

	public function toggleAlert(Request $request)
	{
		$request->validate([
			'alert_id' => 'required'
		]);

		$alert = Alert::where('alert_id', $request->alert_id)->first();

		if($alert){
			if($alert->status){
				return $alert->update([
					'status' => false
				]); 
			}else{
				return $alert->update([
					'status' => true
				]); 
			}
		}else{
			return response()->json(['message' => 'No records found']);
		}

		$update = Alert::where('alert_id', $request->alert_id)->update([
			'status'
		]);
	}
}
