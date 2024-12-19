<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InternationalFilterKeyword extends Model
{
   use HasFactory;
    protected $fillable = [
    	'international_filter_id',
    	'keyword'
    ];

    protected $primaryKey = 'international_filter_keyword_id';
}
