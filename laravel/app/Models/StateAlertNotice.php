<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StateAlertNotice extends Model
{
    use HasFactory;

    protected $fillable = [
    	'alert_id',
    	'state_notice_id'
    ];

    protected $primaryKey = 'state_alert_notice_id';
}
