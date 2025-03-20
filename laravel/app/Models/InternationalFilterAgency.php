<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InternationalFilterAgency extends Model
{
    use HasFactory;
    protected $fillable = [
    	'international_filter_id',
    	'international_agency_id'
    ];

    protected $primaryKey = 'international_filter_agency_id';
}
