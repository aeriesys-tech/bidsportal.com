<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StateFilterCategory extends Model
{
    use HasFactory;
    protected $fillable = [
    	'state_filter_id',
    	'category_id'
    ];

    protected $primaryKey = 'state_filter_category_id';
}
