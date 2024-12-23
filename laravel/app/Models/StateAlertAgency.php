<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StateAlertAgency extends Model
{
    use HasFactory;
    protected $fillable = [
    	'alert_id',
    	'state_agency_id'
    ];

    protected $primaryKey = 'state_alert_agency_id';
}
