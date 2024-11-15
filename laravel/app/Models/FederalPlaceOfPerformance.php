<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FederalPlaceOfPerformance extends Model
{
    use HasFactory;

    protected $fillable = [
    	'federal_tender_id',
        'city_code',
        'city_name',
        'state_code',
        'state_name',
        'country_code',
        'country_name',
        'zip'
    ];

    protected $primaryKey = 'federal_place_of_performance_id';
}
