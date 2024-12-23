<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    use HasFactory;
    protected $fillable = [
    	'alert_title',
    	'region',
    	'user_id',
    	'frequency',
    	'posted_date',
        'active',
        'expired',
    	'posted_from_date',
    	'posted_to_date',
    	'response_date',
    	'response_from_date',
    	'response_to_date',
    	'status'
    ];

    protected $primaryKey = 'alert_id';

    public function User(){
        return $this->belongsTo('App\Models\User', 'user_id', 'user_id');
    }

    public function AlertKeywords(){
        return $this->hasMany('App\Models\AlertKeyword', 'alert_id', 'alert_id');
    }

    public function FederalAlertNotices(){
        return $this->hasMany('App\Models\FederalAlertNotice', 'alert_id', 'alert_id');
    }

    public function StateAlertNotices(){
        return $this->hasMany('App\Models\StateAlertNotice', 'alert_id', 'alert_id');
    }

    public function PrivateAlertNotices(){
        return $this->hasMany('App\Models\PrivateAlertNotice', 'alert_id', 'alert_id');
    }

    public function InternationalAlertNotices(){
        return $this->hasMany('App\Models\InternationalAlertNotice', 'alert_id', 'alert_id');
    }

    public function AlertNaics(){
        return $this->hasMany('App\Models\AlertNaics', 'alert_id', 'alert_id');
    }

    public function AlertPscs(){
        return $this->hasMany('App\Models\AlertPsc', 'alert_id', 'alert_id');
    }

    public function AlertStates(){
        return $this->hasMany('App\Models\AlertState', 'alert_id', 'alert_id');
    }

    public function AlertSetAsides(){
        return $this->hasMany('App\Models\AlertSetAside', 'alert_id', 'alert_id');
    }

    public function FederalAlertAgencies(){
        return $this->hasMany('App\Models\FederalAlertAgency', 'alert_id', 'alert_id');
    }

    public function StateAlertAgencies(){
        return $this->hasMany('App\Models\StateAlertAgency', 'alert_id', 'alert_id');
    }

    public function PrivateAlertAgencies(){
        return $this->hasMany('App\Models\PrivateAlertAgency', 'alert_id', 'alert_id');
    }

    public function InternationalAlertAgencies(){
        return $this->hasMany('App\Models\InternationalAlertAgency', 'alert_id', 'alert_id');
    }

    public function AlertCategories(){
        return $this->hasMany('App\Models\AlertCategory', 'alert_id', 'alert_id');
    }
}
