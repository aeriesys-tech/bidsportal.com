<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FederalFilterNaics extends Model
{
    use HasFactory;
    protected $fillable = [
    	'federal_filter_id',
    	'naics_id'
    ];

    protected $primaryKey = 'federal_filter_naics_id';
}
