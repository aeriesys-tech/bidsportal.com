<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PscResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $is_psc = false;
        $psces = false;
        $isOpen = false;

        //Code to show selected naics
        // if($request->alert_id){
        //     $alert_psces = Alert::select('psc')->where('id', $request->alert_id)->first();
        //     if($alert_psces){
        //         $psces = explode(',', $alert_psces->psc);
        //     }
        // }else if(!empty($request->tdr_psc)){
        //     $psces = $request->tdr_psc;
        // }else{

        // }
        // if($psces){
        //     if (in_array($this->psc_code, $psces)) {
        //          $is_psc = true;
        //     }
        // }

        return [
            "psc_id"=>$this->psc_id,
            "psc_parent_id"=>$this->psc_parent_id,                             
            "psc_code"=>$this->psc_code,                             
            "name"=>$this->psc_description,
            "selected"=> $is_psc,
            "psces" => $psces,
            "isOpen" => $isOpen,
            "children" => PscResource::collection($this->Psc)                    
        ];
    }
}
