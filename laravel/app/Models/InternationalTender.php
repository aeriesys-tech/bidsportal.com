<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InternationalTender extends Model
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
        'international_notice_id',
        'category_id',
        'international_agency_id',
        'tender_url',
        'fees',
        'type_of_award',
        'place_of_performance',
        'contracting_office_address',
        'notice_id',
        'description_link',
        'category_name',
        'notice_name',
        'agency_name',
        'document_path',
        'status',
       
    ];

    protected $primaryKey = 'international_tender_id';

    public function InternationalTenderDetails(){
        
        $place_of_performance = null;
        if($this->InternationalOfficeAddress && !$place_of_performance){
            if($this->InternationalOfficeAddress->city){
                $place_of_performance = $this->InternationalOfficeAddress->city;                
            }

            if($this->InternationalOfficeAddress->state){   
                $place_of_performance = $place_of_performance ?  $place_of_performance.', '.$this->InternationalOfficeAddress->state : $this->InternationalOfficeAddress->state;
            }

            if($this->InternationalOfficeAddress->country){
                $place_of_performance = $place_of_performance ? $place_of_performance.', '.$this->InternationalOfficeAddress->country : $this->InternationalOfficeAddress->country;
            }            
        } else{
            $place_of_performance = null;
        }

        if($this->InternationalNotice){
            $notice = $this->InternationalNotice->international_notice_name;
        }else{
            $notice = null;
        }

        if($this->Category){
            $category = $this->Category->category_name;
        }else{
            $category = null;
        }
        return ([
            'place_of_performance' => $place_of_performance,
            'notice' => $notice,
            'tender_url' => $this->tender_url,
            'category' => $category
        ]);   
    }

    public function Country()
    {
        return $this->belongsTo('App\Models\Country','country_id','country_id');
    }

    public function State()
    {
        return $this->belongsTo('App\Models\State','state_id','state_id');
    }

    public function InternationalNotice()
    {
        return $this->belongsTo('App\Models\InternationalNotice','international_notice_id','international_notice_id');
    }

    public function Category()
    {
        return $this->belongsTo('App\Models\Category','category_id','category_id');
    }

    public function InternationalAgency()
    {
        return $this->belongsTo('App\Models\InternationalAgency','international_agency_id','international_agency_id');
    }

    public function InternationalOfficeAddress()
    {
        return $this->belongsTo('App\Models\InternationalOfficeAddress','international_tender_id','international_tender_id');
    }

    public function InternationalAttachments()
    {
        return $this->hasMany('App\Models\InternationalAttachment','international_tender_id','international_tender_id');
    }

    public function InternationalContacts()
    {
        return $this->hasMany('App\Models\InternationalContact','international_tender_id','international_tender_id');
    }
    
    public function InternationalContactPrimary()
    {
        return $this->hasOne('App\Models\InternationalContact', 'international_tender_id', 'international_tender_id')
                ->where('type', 'Primary');
    }
    
    public function InternationalContactSecondary()
    {
        return $this->hasOne('App\Models\InternationalContact','international_tender_id','international_tender_id')->where('type', 'Secondary');
    }
}
