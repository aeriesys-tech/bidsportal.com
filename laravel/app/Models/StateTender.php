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
        'notice_id',
        'description_link',
        'category_name',
        'notice_name',
        'agency_name'
    ];

    protected $primaryKey = 'state_tender_id';

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
    
}
