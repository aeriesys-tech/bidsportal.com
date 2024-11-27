<?php

namespace App\Http\Controllers;
use App\Models\FederalAgency;
use Illuminate\Http\Request;
use App\Http\Resources\FederalAgencyResource;
use Illuminate\Support\Facades\Cache;

class FederalAgencyController extends Controller
{
	public function getFederalAgencies(Request $request){
		$cacheKey = 'federal_agencies';
        $federal_agencies = Cache::remember($cacheKey, 60 * 60, function () use($request) {
        	return FederalAgency::orderBy('agency_name')->get();
        });
        return $federal_agencies;
	}

	public function paginateFederalAgencies(Request $request)
	{
		$request->validate([
			'order_by' => 'required',
			'per_page' => 'required|numeric',
			'keyword' => 'required'
		]);
		$query = FederalAgency::query();
		
		if($request->search!='')
		{
			$query->where('agency_name', 'like', "%$request->search%")
			->orWhere('agency_code', 'like', "$request->search%");
		}
		$users = $query->orderBy($request->keyword,$request->order_by)->paginate($request->per_page);
		return FederalAgencyResource::collection($users);
	}

	public function addFederalAgency(Request $request)
	{
		$data = $request->validate([
			'agency_name' => 'required',
			'agency_code' => 'required'
		]);

		$state = FederalAgency::create($data);
		return new FederalAgencyResource($state);
	}

	public function getFederalAgency(Request $request)
	{
	$request->validate([
		'federal_agency_id' => 'required|exists:federal_agencies,federal_agency_id'
	]);

	$admin = FederalAgency::where('federal_agency_id', $request->federal_agency_id)->first();
	return new FederalAgencyResource($admin);
	}

	public function updateFederalAgency(Request $request)
	{
		$data = $request->validate([
			'federal_agency_id' => 'required|exists:federal_agencies,federal_agency_id',
			'agency_name' => 'required',
			'agency_code' => 'required'
		]);

		$state = FederalAgency::where('federal_agency_id', $request->federal_agency_id)->first();
		$state->update($data);
		return new FederalAgencyResource($state);
	}

	public function deleteFederalAgency(Request $request)
	{
		$request->validate([
		'federal_agency_id' => 'required|exists:federal_agencies,federal_agency_id'
		]);

		FederalAgency::where('federal_agency_id', $request->federal_agency_id)->delete();
		return response()->json([
		"message" => 'FederalAgency Deleted Successfully'
		]);
	}
}
