<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PrivateAgency;
use App\Http\Resources\PrivateAgencyResource;

class PrivateAgencyController extends Controller
{
    public function paginatePrivateAgencies(Request $request)
    {
        $request->validate([
            'order_by' => 'required',
            'per_page' => 'required',
            'keyword' => 'required'
        ]);

        $query = PrivateAgency::query();

        if($request->search!='')
        {
            $query->where('state_agency_name', 'like', "%$request->search%")->orWhere('state_agency_code', 'like', "%$request->search%");
        }

        $notices = $query->orderBy($request->keyword, $request->order_by)->paginate($request->per_page); 
        return PrivateAgencyResource::collection($notices);
    }

    public function addPrivateAgency(Request $request)
    {
        $data = $request->validate([
            'private_agency_name' => 'required|unique:private_agencies,private_agency_name',
            'private_agency_code' => 'sometimes|nullable'
        ]);

        $notice = PrivateAgency::create($data);
        return new PrivateAgencyResource($notice);
    }

    public function getPrivateAgency(Request $request)
    {
        $request->validate([
            'private_agency_id' => 'required|exists:private_agencies,private_agency_id'
        ]);

        $notice = PrivateAgency::where('private_agency_id', $request->private_agency_id)->first();
        return new PrivateAgencyResource($notice);
    }

    public function getPrivateAgencies(Request $request)
    {
        $notice = PrivateAgency::all();
        return new PrivateAgencyResource($notice);
    }

    public function updatePrivateAgency(Request $request)
    {
        $data = $request->validate([
            'private_agency_id' => 'required|exists:private_agencies,private_agency_id',
            'private_agency_name' => 'required|unique:private_agencies,private_agency_name,'.$request->private_agency_id.',private_agency_id',
            'private_agency_code' => 'sometimes|nullable'
        ]);

        $notice = PrivateAgency::where('private_agency_id', $request->private_agency_id)->first();
        $notice->update($data);
        return new PrivateAgencyResource($notice);
    }

    public function deletePrivateAgency(Request $request)
    {
       $request->validate([
            'private_agency_id' => 'required|exists:private_agencies,private_agency_id'
        ]);

        $notice = PrivateAgency::where('private_agency_id', $request->private_agency_id)->first();
        if($notice->trashed()) 
        {
            $notice->restore();
            return response()->json([
                "message" =>"Private Agency Activated successfully"
            ],200);
        } 
        else 
        {
            $notice->delete();
            return response()->json([
                "message" =>"Private Agency Deactivated successfully"
            ], 200); 
        }
    }
}
