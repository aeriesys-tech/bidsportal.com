<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlertNaics extends Model
{
    use HasFactory;
    protected $fillable = [
    	'alert_id',
    	'naics_id'
    ];

    protected $primaryKey = 'alert_naics_id';
}
