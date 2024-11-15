<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlertSetAside extends Model
{
    use HasFactory;
    protected $fillable = [
    	'alert_id',
    	'set_aside_id'
    ];

    protected $primaryKey = 'alert_set_aside_id';
}
