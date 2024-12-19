<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrivateFilterCategory extends Model
{
    use HasFactory;
    protected $fillable = [
    	'private_filter_id',
    	'category_id'
    ];

    protected $primaryKey = 'private_filter_category_id';
}
