<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InternationalAlertNotice extends Model
{
    use HasFactory;

    protected $fillable = [
    	'alert_id',
    	'international_notice_id'
    ];

    protected $primaryKey = 'international_alert_notice_id';
}
