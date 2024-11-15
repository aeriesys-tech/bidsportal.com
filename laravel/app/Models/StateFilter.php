<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StateFilter extends Model
{
    use HasFactory;
    protected $fillable = [
    	'state_filter_name',
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

    protected $primaryKey = 'state_filter_id';

    public function User(){
        return $this->belongsTo('App\Models\User', 'user_id', 'user_id');
    }

    public function StateFilterKeywords(){
        return $this->hasMany('App\Models\StateFilterKeyword', 'state_filter_id', 'state_filter_id');
    }

    public function StateFilterStatuses(){
        return $this->hasMany('App\Models\StateFilterStatus', 'state_filter_id', 'state_filter_id');
    }

    public function StateFilterNotices(){
        return $this->hasMany('App\Models\StateFilterNotice', 'state_filter_id', 'state_filter_id');
    }

    public function StateFilterNaics(){
        return $this->hasMany('App\Models\StateFilterNaics', 'state_filter_id', 'state_filter_id');
    }

    public function StateFilterPscs(){
        return $this->hasMany('App\Models\StateFilterPsc', 'state_filter_id', 'state_filter_id');
    }

    public function StateFilterStates(){
        return $this->hasMany('App\Models\StateFilterState', 'state_filter_id', 'state_filter_id');
    }

    public function StateFilterSetAsides(){
        return $this->hasMany('App\Models\StateFilterSetAside', 'state_filter_id', 'state_filter_id');
    }

    public function StateFilterAgencies(){
        return $this->hasMany('App\Models\StateFilterAgency', 'state_filter_id', 'state_filter_id');
    }
}
