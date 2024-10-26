<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FederalFilter extends Model
{
    use HasFactory;
    protected $fillable = [
    	'federal_filter_name',
    	'user_id',
    	'posted_date',
        'active',
        'expired',
    	'posted_from_date',
    	'posted_to_date',
    	'response_date',
    	'response_from_date',
    	'response_to_date'
    ];

    protected $primaryKey = 'federal_filter_id';

    public function User(){
        return $this->belongsTo('App\Models\User', 'user_id', 'user_id');
    }

    public function FederalFilterKeywords(){
        return $this->hasMany('App\Models\FederalFilterKeyword', 'federal_filter_id', 'federal_filter_id');
    }

    public function FederalFilterStatuses(){
        return $this->hasMany('App\Models\FederalFilterStatus', 'federal_filter_id', 'federal_filter_id');
    }

    public function FederalFilterNotices(){
        return $this->hasMany('App\Models\FederalFilterNotice', 'federal_filter_id', 'federal_filter_id');
    }

    public function FederalFilterNaics(){
        return $this->hasMany('App\Models\FederalFilterNaics', 'federal_filter_id', 'federal_filter_id');
    }

    public function FederalFilterPscs(){
        return $this->hasMany('App\Models\FederalFilterPsc', 'federal_filter_id', 'federal_filter_id');
    }

    public function FederalFilterStates(){
        return $this->hasMany('App\Models\FederalFilterState', 'federal_filter_id', 'federal_filter_id');
    }

    public function FederalFilterSetAsides(){
        return $this->hasMany('App\Models\FederalFilterSetAside', 'federal_filter_id', 'federal_filter_id');
    }

    public function FederalFilterAgencies(){
        return $this->hasMany('App\Models\FederalFilterAgency', 'federal_filter_id', 'federal_filter_id');
    }
}
