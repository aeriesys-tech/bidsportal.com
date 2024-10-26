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
        'agency_name'
    ];

    protected $primaryKey = 'federal_tender_id';

    public function FederalNotice()
    {
        return $this->belongsTo('App\Models\FederalNotice','federal_notice_id','federal_notice_id');
    }

    public function FederalAgency()
    {
        return $this->belongsTo('App\Models\FederalAgency','federal_agency_id','federal_agency_id');
    }
}
