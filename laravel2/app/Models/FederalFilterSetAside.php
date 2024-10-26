<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FederalFilterSetAside extends Model
{
    use HasFactory;
    protected $fillable = [
    	'federal_filter_id',
    	'set_aside_id'
    ];

    protected $primaryKey = 'federal_filter_set_aside_id';
}
