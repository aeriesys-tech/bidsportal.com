<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StateFilterKeyword extends Model
{
    use HasFactory;
    protected $fillable = [
    	'state_filter_id',
    	'keyword'
    ];

    protected $primaryKey = 'state_filter_keyword_id';
}
