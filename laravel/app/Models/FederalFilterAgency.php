<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FederalFilterAgency extends Model
{
    use HasFactory;
    protected $fillable = [
    	'federal_filter_id',
    	'federal_agency_id'
    ];

    protected $primaryKey = 'federal_filter_agency_id';
}
