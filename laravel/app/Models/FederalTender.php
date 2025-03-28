<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FederalTender extends Model
{
    use HasFactory;

    protected $fillable = [
        'tender_no',
        'title',
        'description',
        'opening_date',
        'posted_date',
        'expiry_date',
        'country_id',
        'state_id',
        'tender_type_id',
        'federal_notice_id',
        'category_id',
        'federal_agency_id',
        'set_aside_id',
        'naics_id',
        'psc_id',
        'contract_type_id',
        'award_type_id',
        'tender_url',
        'fees',
        'type_of_award',
        'place_of_performance',
        'notice_id',
        'description_link',
        'category_name',
        'notice_name',
        'agency_name',
        'is_latest',
        'tender_number'
    ];

    protected $primaryKey = 'federal_tender_id';

    public function FederalTenderDetails(){
        $place_of_performance = null;
        if($this->FederalPlaceOfPerformance){
            if($this->FederalPlaceOfPerformance->city_name){
                $place_of_performance = $this->FederalPlaceOfPerformance->city_name;                
            }

            if($this->FederalPlaceOfPerformance->state_name){
                $place_of_performance = $place_of_performance ? $place_of_performance.', '.$this->FederalPlaceOfPerformance->state_name : $this->FederalPlaceOfPerformance->state_name;
            }

            if($this->FederalPlaceOfPerformance->country_name){
                $place_of_performance = $place_of_performance ? $place_of_performance.', '.$this->FederalPlaceOfPerformance->country_name : $this->FederalPlaceOfPerformance->country_name;
            }

        } else if($this->FederalOfficeAddress && !$place_of_performance){
            if($this->FederalOfficeAddress->city){
                $place_of_performance = $this->FederalOfficeAddress->city;                
            }

            if($this->FederalOfficeAddress->state){   
                $place_of_performance = $place_of_performance ?  $place_of_performance.', '.$this->FederalOfficeAddress->state : $this->FederalOfficeAddress->state;
            }

            if($this->FederalOfficeAddress->country){
                $place_of_performance = $place_of_performance ? $place_of_performance.', '.$this->FederalOfficeAddress->country : $this->FederalOfficeAddress->country;
            }            
        } else{
            $place_of_performance = null;
        }

        if($this->FederalNotice){
            $notice = $this->FederalNotice->notice_name;
        }else{
            $notice = null;
        }

        if($this->Category){
            $category = $this->Category->category_name;
        }else{
            $category = null;
        }
        if($this->FederalOfficeAddress->state){ 
            $state = $this->FederalOfficeAddress->state;
        }else{
            $state = null;
        }
        return ([
            'place_of_performance' => $place_of_performance,
            'notice' => $notice,
            'tender_url' => $this->tender_url,
            'category' => $category,
            'state' => $state
        ]);   
    }


    public function CartItem()
    {
        return $this->hasMany('App\Models\CartItem','federal_tender_id','federal_tender_id');
    }

    public function FederalNotice()
    {
        return $this->belongsTo('App\Models\FederalNotice','federal_notice_id','federal_notice_id');
    }

    public function Category()
    {
        return $this->belongsTo('App\Models\Category','category_id','category_id');
    }

    public function FederalAgency()
    {
        return $this->belongsTo('App\Models\FederalAgency','federal_agency_id','federal_agency_id');
    }

    public function FederalOfficeAddress()
    {
        return $this->belongsTo('App\Models\FederalOfficeAddress','federal_tender_id','federal_tender_id');
    }

    public function FederalPlaceOfPerformance()
    {
        return $this->belongsTo('App\Models\FederalPlaceOfPerformance','federal_tender_id','federal_tender_id');
    }

    public function SetAside()
    {
        return $this->belongsTo('App\Models\SetAside','set_aside_id','set_aside_id');
    }

    public function Naics()
    {
        return $this->belongsTo('App\Models\Naics','naics_id','naics_id');
    }

    public function Psc()
    {
        return $this->belongsTo('App\Models\Psc','psc_id','psc_id');
    }

    public function FederalAttachments()
    {
        return $this->hasMany('App\Models\FederalAttachment','federal_tender_id','federal_tender_id');
    }

    public function FederalContacts()
    {
        return $this->hasMany('App\Models\FederalContact','federal_tender_id','federal_tender_id');
    }

    public function FederalContactPrimary()
    {
        return $this->hasOne('App\Models\FederalContact', 'federal_tender_id', 'federal_tender_id')
                ->where('type', '0');
    }
    
    public function FederalContactSecondary()
    {
        return $this->hasOne('App\Models\FederalContact','federal_tender_id','federal_tender_id')->where('type', '1');
    }
}
