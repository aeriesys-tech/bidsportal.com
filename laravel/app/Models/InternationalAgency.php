<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InternationalAgency extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'international_agency_name',
        'international_agency_code'
    ];

    protected $primaryKey = 'international_agency_id';
}
