<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrivateFilterNotice extends Model
{
    use HasFactory;
    protected $fillable = [
    	'private_filter_id',
    	'private_notice_id'
    ];

    protected $primaryKey = 'private_filter_notice_id';
}
