<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
            // foreach ($naicses as $value) {
            //     $arr = str_split($value);
            //     $search_arr = [];
            //     $search_element = "";
            //     foreach ($arr as $value) {
            //         if(!$search_element){
            //             $search_element = $value;
            //             array_push($search_arr, $search_element);
            //         }else{
            //             $search_element = $search_element.''.$value;
            //             array_push($search_arr, $search_element);
            //         }
            //     }
            //     $remove_first_element = array_shift($search_arr);
            //     if (str_contains($this->naics_code, '-')) { 
            //         $str = explode("-", $this->naics_code);
            //         foreach ($str as $element) {
            //             if (in_array($element, $search_arr)) { 
            //                 $is_naics = true;
            //             }
            //         }
            //     }else{
            //         if (in_array($this->naics_code, $search_arr)) { 
            //             $is_naics = true;
            //         }
            //     }
            // }
        }

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
