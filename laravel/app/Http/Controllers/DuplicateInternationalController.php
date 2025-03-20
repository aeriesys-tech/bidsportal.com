<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DuplicateInternationalTender;
use App\Http\Resources\DuplicateInternationalTenderResource;

class DuplicateInternationalController extends Controller
{
    public function paginateDuplicateInternationalTenders(Request $request)
    {
        $request->validate([
            'order_by' => 'required',
            'per_page' => 'required|numeric'
        ]);
        $query = DuplicateInternationalTender::query();

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

            $query->orderByRaw("MATCH(tender_no, title) AGAINST(? IN NATURAL LANGUAGE MODE) DESC, international_tender_id DESC", [$searchQuery]);
        }

        if($request->search!='')
        {
            $query->where('tender_no', 'like', "%$request->search%")->orWhere('title', 'like', "%$request->search%")
           ->orwhereHas('State', function($qu) use($request){
                $qu->where('state_name', 'like', "%$request->search%");
            });
        }

        $query->orderBy('duplicate_international_tender_id', 'DESC');
        $state_tenders = $query->paginate($request->per_page); 
        return DuplicateInternationalTenderResource::collection($state_tenders);
    }

    public function deleteDuplicateInternationalTenders(Request $request)
    {
        $delete_tenders = $request->input('delete_tenders');
        DuplicateInternationalTender::whereIn('duplicate_international_tender_id', $delete_tenders)->delete();
        
        return response()->json([
            "message" => "Duplicate International Tenders Deleted Successfully"
        ]);
    }
}
