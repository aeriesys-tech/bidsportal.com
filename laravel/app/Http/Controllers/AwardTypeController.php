<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AwardType;
use App\Http\Resources\AwardTypeResource;

class AwardTypeController extends Controller
{
    public function getAwardTypes(Request $request){
        return AwardType::orderBy('sort')->get();
	}

	public function paginateAwardTypes(Request $request)
	  {
	      $request->validate([
	          'order_by' => 'required',
	          'per_page' => 'required|numeric',
	          'keyword' => 'required'
	      ]);
	      $query = AwardType::query();
	        
	      if($request->search!='')
	      {
	          $query->where('award_type_name', 'like', "%$request->search%");
	      }
	      $award_types = $query->orderBy($request->keyword,$request->order_by)->paginate($request->per_page);
	      return AwardTypeResource::collection($award_types);
	  }

	  public function addAwardType(Request $request)
	  {
	      $data = $request->validate([
	          'award_type_name' => 'required|unique:award_types,award_type_name',
	          'sort' => 'nullable'
	      ]);

	      $award = AwardType::create($data);
	      return $award;
	  }

	  public function getAwardType(Request $request)
	  {
	      $request->validate([
	          'award_type_id' => 'required|exists:award_types,award_type_id'
	      ]);

	      $award = AwardType::where('award_type_id', $request->award_type_id)->first();
	      return $award;
	  }

	  public function updateAwardType(Request $request)
	  {
	      $data = $request->validate([
	          'award_type_id' => 'required|exists:award_types,award_type_id',
	          'award_type_name' => 'required|unique:award_types,award_type_name,'.$request->award_type_id.',award_type_id',
	          'sort' => 'nullable'
	      ]);

	      $award = AwardType::where('award_type_id', $request->award_type_id)->first();
	      $award->update($data);
	      return $award;
	  }

	  public function deleteAwardType(Request $request)
	  {
	      $request->validate([
	          'award_type_id' => 'required|exists:award_types,award_type_id'
	      ]);

	      AwardType::where('award_type_id', $request->award_type_id)->delete();
	      return response()->json([
	          "message" => 'Award Deleted Successfully'
	      ]);
	  }
}
