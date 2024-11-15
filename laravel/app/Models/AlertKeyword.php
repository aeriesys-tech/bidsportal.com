<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlertKeyword extends Model
{
    use HasFactory;
    protected $fillable = [
    	'alert_id',
    	'keyword'
    ];

    protected $primaryKey = 'alert_keyword_id';
}
