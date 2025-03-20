<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrivateAlertNotice extends Model
{
    use HasFactory;

    protected $fillable = [
    	'alert_id',
    	'private_notice_id'
    ];

    protected $primaryKey = 'private_alert_notice_id';
}
