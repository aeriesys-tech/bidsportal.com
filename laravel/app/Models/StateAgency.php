<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StateAgency extends Model
{
   use HasFactory, softDeletes;

    protected $fillable = [
        'state_agency_name',
        'state_agency_code'
    ];

    protected $primaryKey = 'state_agency_id';
}
