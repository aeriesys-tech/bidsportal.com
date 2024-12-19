<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrivateFilterKeyword extends Model
{
    use HasFactory;
    protected $fillable = [
    	'private_filter_id',
    	'keyword'
    ];

    protected $primaryKey = 'private_filter_keyword_id';
}
