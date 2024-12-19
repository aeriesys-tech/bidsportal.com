<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InternationalFilterCategory extends Model
{
    use HasFactory;
    protected $fillable = [
    	'international_filter_id',
    	'category_id'
    ];

    protected $primaryKey = 'international_filter_category_id';
}
