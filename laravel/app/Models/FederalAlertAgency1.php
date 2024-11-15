<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FederalAlertAgency extends Model
{
    use HasFactory;
    protected $fillable = [
    	'federal_alert_id',
    	'federal_agency_id'
    ];

    protected $primaryKey = 'federal_alert_agency_id';
}
