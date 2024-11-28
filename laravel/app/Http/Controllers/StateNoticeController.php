<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StateNotice;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\StateNoticeResource;

class StateNoticeController extends Controller
{
    public function getStateNotices(Request $request){
    	$cacheKey = 'state_notice';
        $state_notices = Cache::remember($cacheKey, 60 * 60, function () {
            return StateNotice::where('sort', '!=', 0)->orderBy('sort')->get();
        });
        return $state_notices;
    }

    public function paginateStateNotices(Request $request)
    {
        $request->validate([
            'order_by' => 'required',
            'per_page' => 'required|numeric',
            'keyword' => 'required'
        ]);
    	  $query = StateNotice::query();
          
        if($request->search!='')
        {
            $query->where('notice_name', 'like', "%$request->search%")
              ->orWhere('sort', 'like', "$request->search%");
        }
    	  $users = $query->orderBy($request->keyword,$request->order_by)->paginate($request->per_page);
        return StateNoticeResource::collection($users);
    }

    public function addStateNotice(Request $request)
    {
        $data = $request->validate([
            'notice_name' => 'required',
            'sort' => 'nullable',
            'background_color' => 'nullable'
        ]);

        $state = StateNotice::create($data);
        return new StateNoticeResource($state);
    }

    public function getStateNotice(Request $request)
    {
        $request->validate([
            'state_notice_id' => 'required|exists:state_notices,state_notice_id'
        ]);

        $admin = StateNotice::where('state_notice_id', $request->state_notice_id)->first();
        return new StateNoticeResource($admin);
    }

    public function updateStateNotice(Request $request)
    {
        $data = $request->validate([
            'state_notice_id' => 'required|exists:state_notices,state_notice_id',
            'notice_name' => 'required',
            'sort' => 'nullable',
            'background_color' => 'nullable'
        ]);

        $state = StateNotice::where('state_notice_id', $request->state_notice_id)->first();
        $state->update($data);
        return new StateNoticeResource($state);
    }

    public function deleteStateNotice(Request $request)
    {
        $request->validate([
            'state_notice_id' => 'required|exists:state_notices,state_notice_id'
        ]);

        StateNotice::where('state_notice_id', $request->state_notice_id)->forceDelete();
        return response()->json([
            "message" => 'StateAgency Deleted Successfully'
        ]);
    }
}
