<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FederalFilterState extends Model
{
    use HasFactory;
    protected $fillable = [
    	'federal_filter_id',
    	'state_id'
    ];

    protected $primaryKey = 'federal_filter_state_id';
}