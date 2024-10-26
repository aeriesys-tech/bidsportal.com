<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FederalAgency extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'federal_agency_name',
        'federal_agency_code'
    ];

    protected $primaryKey = 'federal_agency_id';
}
