<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrivateFilterAgency extends Model
{
    use HasFactory;
    protected $fillable = [
    	'private_filter_id',
    	'private_agency_id'
    ];

    protected $primaryKey = 'private_filter_agency_id';
}
