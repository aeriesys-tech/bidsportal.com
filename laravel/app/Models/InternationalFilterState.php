<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InternationalFilterState extends Model
{
    use HasFactory;
    protected $fillable = [
    	'international_filter_id',
    	'state_id'
    ];

    protected $primaryKey = 'international_filter_state_id';
}
