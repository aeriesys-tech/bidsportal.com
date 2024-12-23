<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InternationalAlertAgency extends Model
{
    use HasFactory;
    protected $fillable = [
    	'alert_id',
    	'international_agency_id'
    ];

    protected $primaryKey = 'international_alert_agency_id';
}
