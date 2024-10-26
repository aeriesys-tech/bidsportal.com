<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FederalFilterStatus extends Model
{
    use HasFactory;
    protected $fillable = [
    	'federal_filter_id',
    	'status'
    ];

    protected $primaryKey = 'federal_filter_status_id';
}
