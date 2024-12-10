<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InternationalAgency;
use App\Http\Resources\InternationalAgencyResource;

class InternationalAgencyController extends Controller
{
    public function paginateInternationalAgencies(Request $request)
    {
        $request->validate([
            'order_by' => 'required',
            'per_page' => 'required',
            'keyword' => 'required'
        ]);

        $query = InternationalAgency::query();

        if($request->search!='')
        {
            $query->where('international_agency_name', 'like', "%$request->search%")->orwhere('international_agency_code', 'like', "%$request->search%");
        }

        $agencies = $query->orderBy($request->keyword, $request->order_by)->paginate($request->per_page); 
        return InternationalAgencyResource::collection($agencies);
    }

    public function addInternationalAgency(Request $request)
    {
        $data = $request->validate([
            'international_agency_name' => 'required|unique:international_agencies,international_agency_name',
            'international_agency_code' => 'nullable'
        ]);

        $agency = InternationalAgency::create($data);
        return new InternationalAgencyResource($agency);
    }

    public function getInternationalAgency(Request $request)
    {
        $request->validate([
            'international_agency_id' => 'required|exists:international_agencies,international_agency_id'
        ]);

        $agency = InternationalAgency::where('international_agency_id', $request->international_agency_id)->first();
        return new InternationalAgencyResource($agency);
    }

    public function getInternationalAgencies(Request $request)
    {
        $agencies = InternationalAgency::all();
        return InternationalAgencyResource::collection($agencies);
    }

    public function updateInternationalAgency(Request $request)
    {
        $data = $request->validate([
            'international_agency_id' => 'required|exists:international_agencies,international_agency_id',
            'international_agency_name' => 'required|unique:international_agencies,international_agency_name,'.$request->international_agency_id.',international_agency_id',
            'international_agency_code' => 'nullable'
        ]);

        $agency = InternationalAgency::where('international_agency_id', $request->international_agency_id)->first();
        $agency->update($data);
        return new InternationalAgencyResource($agency);
    }

    public function deleteInternationalAgency(Request $request)
    {
       $request->validate([
            'international_agency_id' => 'required|exists:international_agencies,international_agency_id'
        ]);

        InternationalAgency::where('international_agency_id', $request->international_agency_id)->forceDelete();
        return response()->json([
            "message" => "International Agency Deleted Successfully"
        ]);
    }
}
