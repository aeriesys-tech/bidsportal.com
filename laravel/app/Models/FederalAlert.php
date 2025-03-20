<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FederalAlert extends Model
{
    use HasFactory;
    protected $fillable = [
    	'federal_alert_name',
    	'user_id',
    	'frequency',
    	'posted_date',
        'active',
        'expired',
    	'posted_from_date',
    	'posted_to_date',
    	'response_date',
    	'response_from_date',
    	'response_to_date'
    ];

    protected $primaryKey = 'federal_alert_id';

    public function User(){
        return $this->belongsTo('App\Models\User', 'user_id', 'user_id');
    }

    public function FederalAlertKeywords(){
        return $this->hasMany('App\Models\FederalAlertKeyword', 'federal_alert_id', 'federal_alert_id');
    }

    public function FederalAlertStatuses(){
        return $this->hasMany('App\Models\FederalAlertStatus', 'federal_alert_id', 'federal_alert_id');
    }

    public function FederalAlertNotices(){
        return $this->hasMany('App\Models\FederalAlertNotice', 'federal_alert_id', 'federal_alert_id');
    }

    public function FederalAlertNaics(){
        return $this->hasMany('App\Models\FederalAlertNaics', 'federal_alert_id', 'federal_alert_id');
    }

    public function FederalAlertPscs(){
        return $this->hasMany('App\Models\FederalAlertPsc', 'federal_alert_id', 'federal_alert_id');
    }

    public function FederalAlertStates(){
        return $this->hasMany('App\Models\FederalAlertState', 'federal_alert_id', 'federal_alert_id');
    }

    public function FederalAlertSetAsides(){
        return $this->hasMany('App\Models\FederalAlertSetAside', 'federal_alert_id', 'federal_alert_id');
    }

    public function FederalAlertAgencies(){
        return $this->hasMany('App\Models\FederalAlertAgency', 'federal_alert_id', 'federal_alert_id');
    }

}
