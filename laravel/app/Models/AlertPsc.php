<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlertPsc extends Model
{
    use HasFactory;
    protected $fillable = [
    	'alert_id',
    	'psc_id'
    ];

    protected $primaryKey = 'alert_psc_id';
}
