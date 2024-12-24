<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrivateTender extends Model
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
        'private_notice_id',
        'category_id',
        'private_agency_id',
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

    protected $primaryKey = 'private_tender_id';

    public function PrivateTenderDetails(){
        
        $place_of_performance = null;
        if($this->PrivateOfficeAddress && !$place_of_performance){
            if($this->PrivateOfficeAddress->city){
                $place_of_performance = $this->PrivateOfficeAddress->city;                
            }

            if($this->PrivateOfficeAddress->state){   
                $place_of_performance = $place_of_performance ?  $place_of_performance.', '.$this->PrivateOfficeAddress->state : $this->PrivateOfficeAddress->state;
            }

            if($this->PrivateOfficeAddress->country){
                $place_of_performance = $place_of_performance ? $place_of_performance.', '.$this->PrivateOfficeAddress->country : $this->PrivateOfficeAddress->country;
            }            
        } else{
            $place_of_performance = null;
        }

        if($this->PrivateNotice){
            $notice = $this->PrivateNotice->private_notice_name;
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
        return $this->hasMany('App\Models\CartItem','private_tender_id','private_tender_id');
    }
    public function Country()
    {
        return $this->belongsTo('App\Models\Country','country_id','country_id');
    }

    public function State()
    {
        return $this->belongsTo('App\Models\State','state_id','state_id');
    }

    public function PrivateNotice()
    {
        return $this->belongsTo('App\Models\PrivateNotice','private_notice_id','private_notice_id');
    }

    public function Category()
    {
        return $this->belongsTo('App\Models\Category','category_id','category_id');
    }

    public function PrivateAgency()
    {
        return $this->belongsTo('App\Models\PrivateAgency','private_agency_id','private_agency_id');
    }

    public function PrivateOfficeAddress()
    {
        return $this->belongsTo('App\Models\PrivateOfficeAddress','private_tender_id','private_tender_id');
    }

    public function PrivateAttachments()
    {
        return $this->hasMany('App\Models\PrivateAttachment','private_tender_id','private_tender_id');
    }

    public function PrivateContacts()
    {
        return $this->hasMany('App\Models\PrivateContact','private_tender_id','private_tender_id');
    }
    
    public function PrivateContactPrimary()
    {
        return $this->hasOne('App\Models\PrivateContact', 'private_tender_id', 'private_tender_id')
                ->where('type', 'Primary');
    }
    
    public function PrivateContactSecondary()
    {
        return $this->hasOne('App\Models\PrivateContact','private_tender_id','private_tender_id')->where('type', 'Secondary');
    }
}
