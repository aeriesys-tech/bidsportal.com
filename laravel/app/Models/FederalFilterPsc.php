<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FederalFilterPsc extends Model
{
    use HasFactory;
    protected $fillable = [
    	'federal_filter_id',
    	'psc_id'
    ];

    protected $primaryKey = 'federal_filter_psc_id';
}
