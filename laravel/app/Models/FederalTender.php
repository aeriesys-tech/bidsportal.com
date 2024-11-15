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
        'tender_url',
        'fees',
        'type_of_award',
        'place_of_performance',
        'notice_id',
        'description_link',
        'category_name',
        'notice_name',
        'agency_name',
        'is_latest'
    ];

    protected $primaryKey = 'federal_tender_id';

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
}
