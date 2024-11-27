<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StateAgency;
use Illuminate\Support\Facades\Cache;
use App\Http\resources\StateAgencyResource;

class StateAgencyController extends Controller
{
    public function getStateAgencies(Request $request){
		$cacheKey = 'state_agencies';
        $state_agencies = Cache::remember($cacheKey, 60 * 60, function () use($request) {
        	return StateAgency::orderBy('state_agency_name')->get();
        });
        return $state_agencies;
	}

	public function paginateStateAgencies(Request $request)
    {
        $request->validate([
            'order_by' => 'required',
            'per_page' => 'required|numeric',
            'keyword' => 'required'
        ]);
    	  $query = StateAgency::query();
          
        if($request->search!='')
        {
            $query->where('state_agency_name', 'like', "%$request->search%")
              ->orWhere('state_agency_code', 'like', "$request->search%");
        }
    	  $users = $query->orderBy($request->keyword,$request->order_by)->paginate($request->per_page);
        return StateAgencyResource::collection($users);
    }

    public function addStateAgency(Request $request)
    {
        $data = $request->validate([
            'state_agency_name' => 'required',
            'state_agency_code' => 'required'
        ]);

        $state = StateAgency::create($data);
        return new StateAgencyResource($state);
    }

    public function getStateAgency(Request $request)
    {
      $request->validate([
        'state_agency_id' => 'required|exists:state_agencies,state_agency_id'
      ]);

      $admin = StateAgency::where('state_agency_id', $request->state_agency_id)->first();
      return new StateAgencyResource($admin);
    }

    public function updateStateAgency(Request $request)
    {
        $data = $request->validate([
           'state_agency_id' => 'required|exists:state_agencies,state_agency_id',
            'state_agency_name' => 'required',
            'state_agency_code' => 'required'
        ]);

        $state = StateAgency::where('state_agency_id', $request->state_agency_id)->first();
        $state->update($data);
        return new StateAgencyResource($state);
    }

    public function deleteStateAgency(Request $request)
    {
        $request->validate([
            'state_agency_id' => 'required|exists:state_agencies,state_agency_id'
        ]);

        StateAgency::where('state_agency_id', $request->state_agency_id)->delete();
        return response()->json([
            "message" => 'StateAgency Deleted Successfully'
        ]);
    }
}
