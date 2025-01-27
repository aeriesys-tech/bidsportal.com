<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Naics;

class NaicsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $is_naics = false;
        $naicses = null;
        $isOpen = false;
        //Code to show selected naics
        if($request->alert_id){
            $alert_naicses = Alert::select('naics_id')->where('id', $request->alert_id)->first();
            if($alert_naicses){
                $naicses = explode(',', $alert_naicses->naics_id);
            }
        }else if(!empty($request->tdr_naics)){
            $naicses = $request->tdr_naics;
        }else{

        }
        if($naicses){
            if (in_array($this->naics_code, $naicses)) { 
                $is_naics = true;
            }
        }
        // if($request->search){
        //     $parent_results = Naics::whereNull('naics_parent_id')
        //         ->where(function ($query) use ($request) {
        //             $query->where('naics_code', 'like', '%' . $request->search . '%')
        //                   ->orWhere('naics_description', 'like', '%' . $request->search . '%');
        //         })
        //         ->pluck('naics_id');
        //         $child_results = Naics::where(function ($query) use ($request) {
        //             $query->where('naics_code', 'like', '%' . $request->search . '%')
        //                   ->orWhere('naics_description', 'like', '%' . $request->search . '%');
        //         })
        //         ->select('naics_parent_id')
        //         ->whereNotNull('naics_parent_id')
        //         ->distinct()
        //         ->pluck('naics_parent_id');

        //     $all_parents = $parent_results->merge($child_results)->unique('naics_id')->values();

        //     $naics = Naics::select('naics_id', 'naics_code', 'naics_description')
        //                 ->whereIn('naics_id', $all_parents)->whereNull('naics_parent_id')->get();
        // }else{
        //     $naics = Naics::select('naics_id', 'naics_code', 'naics_description')->get();
        // }

        return [
            "naics_id"=>$this->naics_id,
            "naics_parent_id"=>$this->naics_parent_id,
            "children"=> NaicsResource::collection($this->Naics),                          
            "naics_code"=>$this->naics_code,                             
            "name"=>$this->naics_description, 
            "selected"=> $is_naics,
            "show"=>'all',
            "isOpen" => $isOpen,
            'naicses' => $naicses
        ];
    }
}
