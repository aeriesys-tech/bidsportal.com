<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FederalNotice;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\FederalNoticeResource;

class FederalNoticeController extends Controller
{
    public function getFederalNotices(Request $request){
    	$cacheKey = 'federal_notice';
        $federal_notices = Cache::remember($cacheKey, 60 * 60, function () {
            return FederalNotice::where('sort', '!=', 0)->orderBy('sort')->get();
        });
        return $federal_notices;
    }

     public function paginateFederalNotices(Request $request)
    {
        $request->validate([
            'order_by' => 'required',
            'per_page' => 'required|numeric',
            'keyword' => 'required'
        ]);
    	  $query = FederalNotice::query();
          
        if($request->search!='')
        {
            $query->where('notice_name', 'like', "%$request->search%")
              ->orWhere('sort', 'like', "$request->search%");
        }
    	  $users = $query->orderBy($request->keyword,$request->order_by)->paginate($request->per_page);
        return FederalNoticeResource::collection($users);
    }

    public function addFederalNotice(Request $request)
    {
        $data = $request->validate([
            'notice_name' => 'required',
            'sort' => 'nullable',
            'background_color' => 'nullable'
        ]);

        $state = FederalNotice::create($data);
        return new FederalNoticeResource($state);
    }

    public function getFederalNotice(Request $request)
    {
      $request->validate([
        'federal_notice_id' => 'required|exists:federal_notices,federal_notice_id'
      ]);

      $admin = FederalNotice::where('federal_notice_id', $request->federal_notice_id)->first();
      return new FederalNoticeResource($admin);
    }

    public function updateFederalNotice(Request $request)
    {
        $data = $request->validate([
            'federal_notice_id' => 'required|exists:federal_notices,federal_notice_id',
            'notice_name' => 'required',
            'sort' => 'nullable',
            'background_color' => 'nullable'
        ]);

        $state = FederalNotice::where('federal_notice_id', $request->federal_notice_id)->first();
        $state->update($data);
        return new FederalNoticeResource($state);
    }

    public function deleteFederalNotice(Request $request)
    {
        $request->validate([
            'federal_notice_id' => 'required|exists:federal_notices,federal_notice_id'
        ]);

        FederalNotice::where('federal_notice_id', $request->federal_notice_id)->forceDelete();
        return response()->json([
            "message" => 'StateAgency Deleted Successfully'
        ]);
    }
}
