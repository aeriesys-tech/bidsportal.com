<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InternationalNotice;
use App\Http\Resources\InternationalNoticeResource;
use Illuminate\Validation\Rule;

class InternationalNoticeController extends Controller
{
    public function paginateInternationalNotices(Request $request)
    {
        $request->validate([
            'order_by' => 'required',
            'per_page' => 'required',
            'keyword' => 'required'
        ]);

        $query = InternationalNotice::query();

        if($request->search!='')
        {
            $query->where('international_notice_name', 'like', "%$request->search%");
        }

        $notices = $query->orderBy($request->keyword, $request->order_by)->paginate($request->per_page); 
        return InternationalNoticeResource::collection($notices);
    }

    public function addInternationalNotice(Request $request)
    {
        $data = $request->validate([
            'international_notice_name' => [
                'required',
                Rule::unique('international_notices', 'international_notice_name')->whereNull('deleted_at'),
            ],
            'sort' => 'sometimes|nullable',
            'background_color' => 'sometimes|nullable'
        ]);

        $notice = InternationalNotice::updateOrCreate(
            [
                'international_notice_name' => $data['international_notice_name']
            ],
            [
                'sort' => $data['sort'],
                'background_color' => $data['background_color'],
                'deleted_at' => null
            ]
        );
        return new InternationalNoticeResource($notice);
    }

    public function getInternationalNotice(Request $request)
    {
        $request->validate([
            'international_notice_id' => 'required|exists:international_notices,international_notice_id'
        ]);

        $notice = InternationalNotice::where('international_notice_id', $request->international_notice_id)->first();
        return new InternationalNoticeResource($notice);
    }

    public function getInternationalNotices(Request $request)
    {
        $notice = InternationalNotice::all();
        return new InternationalNoticeResource($notice);
    }

    public function updateInternationalNotice(Request $request)
    {
        $data = $request->validate([
            'international_notice_id' => 'required|exists:international_notices,international_notice_id',
            'international_notice_name' => 'required|unique:international_notices,international_notice_name,'.$request->international_notice_id.',international_notice_id',
            'sort' => 'sometimes|nullable',
            'background_color' => 'sometimes|nullable'
        ]);

        $notice = InternationalNotice::where('international_notice_id', $request->international_notice_id)->first();
        $notice->update($data);
        return new InternationalNoticeResource($notice);
    }

    public function deleteInternationalNotice(Request $request)
    {
       $request->validate([
            'international_notice_id' => 'required|exists:international_notices,international_notice_id'
        ]);

        $notice = InternationalNotice::where('international_notice_id', $request->international_notice_id)->first();
        if($notice->trashed()) 
        {
            $notice->restore();
            return response()->json([
                "message" =>"International Notice Activated successfully"
            ],200);
        } 
        else 
        {
            $notice->delete();
            return response()->json([
                "message" =>"International Notice Deactivated successfully"
            ], 200); 
        }
    }
}
