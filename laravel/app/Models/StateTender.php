<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StateTender extends Model
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
        'state_notice_id',
        'category_id',
        'state_agency_id',
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
        'status',
        'tender_number',
        'upload_type'
    ];

    protected $primaryKey = 'state_tender_id';

    public function StateTenderDetails(){
        
        $place_of_performance = null;
        if($this->StateOfficeAddress && !$place_of_performance){
            if($this->StateOfficeAddress->city){
                $place_of_performance = $this->StateOfficeAddress->city;                
            }

            if($this->StateOfficeAddress->state){   
                $place_of_performance = $place_of_performance ?  $place_of_performance.', '.$this->StateOfficeAddress->state : $this->StateOfficeAddress->state;
            }

            if($this->StateOfficeAddress->country){
                $place_of_performance = $place_of_performance ? $place_of_performance.', '.$this->StateOfficeAddress->country : $this->StateOfficeAddress->country;
            }            
        } else{
            $place_of_performance = null;
        }

        if($this->StateNotice){
            $notice = $this->StateNotice->notice_name;
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

    public function CartItem()
    {
        return $this->hasMany('App\Models\CartItem','state_tender_id','state_tender_id');
    }
    public function Country()
    {
        return $this->belongsTo('App\Models\Country','country_id','country_id');
    }

    public function State()
    {
        return $this->belongsTo('App\Models\State','state_id','state_id');
    }

    public function StateNotice()
    {
        return $this->belongsTo('App\Models\StateNotice','state_notice_id','state_notice_id');
    }

    public function Category()
    {
        return $this->belongsTo('App\Models\Category','category_id','category_id');
    }

    public function StateAgency()
    {
        return $this->belongsTo('App\Models\StateAgency','state_agency_id','state_agency_id');
    }

    public function StateOfficeAddress()
    {
        return $this->belongsTo('App\Models\StateOfficeAddress','state_tender_id','state_tender_id');
    }

    public function StateAttachments()
    {
        return $this->hasMany('App\Models\StateAttachment','state_tender_id','state_tender_id');
    }

    public function StateContacts()
    {
        return $this->hasMany('App\Models\StateContact','state_tender_id','state_tender_id');
    }
    
    public function StateContactPrimary()
    {
        return $this->hasOne('App\Models\StateContact', 'state_tender_id', 'state_tender_id')
                ->where('type', 'Primary');
    }
    
    public function StateContactSecondary()
    {
        return $this->hasOne('App\Models\StateContact','state_tender_id','state_tender_id')->where('type', 'Secondary');
    }
}
