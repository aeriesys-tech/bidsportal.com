<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\PrivateNoticeResource;
use App\Models\PrivateNotice;
use Illuminate\Validation\Rule;

class PrivateNoticeController extends Controller
{
    public function paginatePrivateNotices(Request $request)
    {
        $request->validate([
            'order_by' => 'required',
            'per_page' => 'required',
            'keyword' => 'required'
        ]);

        $query = PrivateNotice::query();

        if($request->search!='')
        {
            $query->where('private_notice_name', 'like', "%$request->search%")->orWhere('sort', 'like', "%$request->search%");
        }

        $notices = $query->orderBy($request->keyword, $request->order_by)->paginate($request->per_page); 
        return PrivateNoticeResource::collection($notices);
    }

    public function addPrivateNotice(Request $request)
    {
        $data = $request->validate([
            'private_notice_name' => [
                'required',
                Rule::unique('private_notices', 'private_notice_name')->whereNull('deleted_at'),
            ],
            'sort' => 'sometimes|nullable',
            'background_color' => 'required'
        ]);

        $notice = PrivateNotice::create($data);
        return new PrivateNoticeResource($notice);
    }

    public function getPrivateNotice(Request $request)
    {
        $request->validate([
            'private_notice_id' => 'required|exists:private_notices,private_notice_id'
        ]);

        $notice = PrivateNotice::where('private_notice_id', $request->private_notice_id)->first();
        return new PrivateNoticeResource($notice);
    }

    public function getPrivateNotices(Request $request)
    {
        $notice = PrivateNotice::all();
        return new PrivateNoticeResource($notice);
    }

    public function updatePrivateNotice(Request $request)
    {
        $data = $request->validate([
            'private_notice_id' => 'required|exists:private_notices,private_notice_id',
            'private_notice_name' => 'required|unique:private_notices,private_notice_name,'.$request->private_notice_id.',private_notice_id',
            'sort' => 'sometimes|nullable',
            'background_color' => 'required'
        ]);

        $notice = PrivateNotice::where('private_notice_id', $request->private_notice_id)->first();
        $notice->update($data);
        return new PrivateNoticeResource($notice);
    }

    public function deletePrivateNotice(Request $request)
    {
       $request->validate([
            'private_notice_id' => 'required|exists:private_notices,private_notice_id'
        ]);

        $notice = PrivateNotice::where('private_notice_id', $request->private_notice_id)->first();
        if($notice->trashed()) 
        {
            $notice->restore();
            return response()->json([
                "message" =>"Private Notice Activated successfully"
            ],200);
        } 
        else 
        {
            $notice->delete();
            return response()->json([
                "message" =>"Private Notice Deactivated successfully"
            ], 200); 
        }
    }
}
