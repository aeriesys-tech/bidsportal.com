<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model
{
   use HasFactory, softDeletes;

    protected $fillable = [
        'state_name',
        'state_code',
        'sort'
    ];

    protected $primaryKey = 'state_id';

    
}
