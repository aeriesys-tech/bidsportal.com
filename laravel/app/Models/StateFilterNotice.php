<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StateFilterNotice extends Model
{
    use HasFactory;
    protected $fillable = [
    	'state_filter_id',
    	'state_notice_id'
    ];

    protected $primaryKey = 'state_filter_notice_id';
}
