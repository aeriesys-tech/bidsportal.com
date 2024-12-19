<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InternationalFilterNotice extends Model
{
    use HasFactory;
    protected $fillable = [
    	'international_filter_id',
    	'international_notice_id'
    ];

    protected $primaryKey = 'international_filter_notice_id';
}
