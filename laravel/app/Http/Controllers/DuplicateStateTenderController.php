<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DuplicateStateTender;
use App\Http\Resources\DuplicateStateTenderResource;

class DuplicateStateTenderController extends Controller
{
    public function paginateDuplicateStateTenders(Request $request)
    {
        $request->validate([
            'order_by' => 'required',
            'per_page' => 'required|numeric'
        ]);
        $query = DuplicateStateTender::query();

        if (!empty($request->keywords)) 
        {
            if (is_string($request->keywords)) {
                $keywords = array_map('trim', explode(',', $request->keywords));
            } else {
                $keywords = array_map('trim', $request->keywords);
            }

            $searchQuery = implode(' ', $keywords);

            // Search for matches
            $query->whereRaw("MATCH(tender_no, title) AGAINST(? IN NATURAL LANGUAGE MODE)", [$searchQuery]);

            $query->orderByRaw("MATCH(tender_no, title) AGAINST(? IN NATURAL LANGUAGE MODE) DESC, state_tender_id DESC", [$searchQuery]);
        }

        if($request->search!='')
        {
            $query->where('tender_no', 'like', "%$request->search%")->orWhere('title', 'like', "%$request->search%")
           ->orwhereHas('State', function($qu) use($request){
                $qu->where('state_name', 'like', "%$request->search%");
            });
        }

        $query->orderBy('duplicate_state_tender_id', 'DESC');
        $state_tenders = $query->paginate($request->per_page); 
        return DuplicateStateTenderResource::collection($state_tenders);
    }

    public function deleteDuplicateStateTenders(Request $request)
    {
        $delete_tenders = $request->input('delete_tenders');
        DuplicateStateTender::whereIn('duplicate_state_tender_id', $delete_tenders)->delete();
        
        return response()->json([
            "message" => "Duplicate State Tenders Deleted Successfully"
        ]);
    }
}
