<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InternationalFilter extends Model
{
    use HasFactory;
    protected $fillable = [
    	'international_filter_name',
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

    protected $primaryKey = 'international_filter_id';

    public function User(){
        return $this->belongsTo('App\Models\User', 'user_id', 'user_id');
    }

    public function InternationalFilterKeywords(){
        return $this->hasMany('App\Models\InternationalFilterKeyword', 'international_filter_id', 'international_filter_id');
    }

    public function InternationalFilterStatuses(){
        return $this->hasMany('App\Models\InternationalFilterStatus', 'international_filter_id', 'international_filter_id');
    }

    public function InternationalFilterNotices(){
        return $this->hasMany('App\Models\InternationalFilterNotice', 'international_filter_id', 'international_filter_id');
    }

    public function InternationalFilterStates(){
        return $this->hasMany('App\Models\InternationalFilterState', 'international_filter_id', 'international_filter_id');
    }

    public function InternationalFilterSetAsides(){
        return $this->hasMany('App\Models\InternationalFilterSetAside', 'international_filter_id', 'international_filter_id');
    }

    public function InternationalFilterAgencies(){
        return $this->hasMany('App\Models\InternationalFilterAgency', 'international_filter_id', 'international_filter_id');
    }
}
