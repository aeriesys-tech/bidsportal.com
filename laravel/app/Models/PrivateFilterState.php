<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrivateFilterState extends Model
{
    use HasFactory;
    protected $fillable = [
    	'private_filter_id',
    	'state_id'
    ];

    protected $primaryKey = 'private_filter_state_id';
}
