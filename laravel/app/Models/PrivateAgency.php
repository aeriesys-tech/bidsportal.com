<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrivateAgency extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'private_agency_name',
        'private_agency_code'
    ];

    protected $primaryKey = 'private_agency_id';
}
