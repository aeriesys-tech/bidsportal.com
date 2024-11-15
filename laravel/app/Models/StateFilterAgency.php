<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StateFilterAgency extends Model
{
    use HasFactory;
    protected $fillable = [
    	'state_filter_id',
    	'state_agency_id'
    ];

    protected $primaryKey = 'state_filter_agency_id';
}
