<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlertState extends Model
{
    use HasFactory;
    protected $fillable = [
    	'alert_id',
    	'state_id'
    ];

    protected $primaryKey = 'alert_state_id';
}
