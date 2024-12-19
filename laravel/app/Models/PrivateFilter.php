<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrivateFilter extends Model
{
    use HasFactory;
    protected $fillable = [
    	'private_filter_name',
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

    protected $primaryKey = 'private_filter_id';

    public function User(){
        return $this->belongsTo('App\Models\User', 'user_id', 'user_id');
    }

    public function PrivateFilterKeywords(){
        return $this->hasMany('App\Models\PrivateFilterKeyword', 'private_filter_id', 'private_filter_id');
    }

    public function PrivateFilterStatuses(){
        return $this->hasMany('App\Models\PrivateFilterStatus', 'private_filter_id', 'private_filter_id');
    }

    public function PrivateFilterNotices(){
        return $this->hasMany('App\Models\PrivateFilterNotice', 'private_filter_id', 'private_filter_id');
    }

    public function PrivateFilterStates(){
        return $this->hasMany('App\Models\PrivateFilterState', 'private_filter_id', 'private_filter_id');
    }

    public function PrivateFilterSetAsides(){
        return $this->hasMany('App\Models\PrivateFilterSetAside', 'private_filter_id', 'private_filter_id');
    }

    public function PrivateFilterAgencies(){
        return $this->hasMany('App\Models\PrivateFilterAgency', 'private_filter_id', 'private_filter_id');
    }
}
