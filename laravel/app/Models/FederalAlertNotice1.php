<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FederalAlertNotice extends Model
{
    use HasFactory;

    protected $fillable = [
    	'federal_alert_id',
    	'federal_notice_id'
    ];

    protected $primaryKey = 'federal_alert_notice_id';
}
