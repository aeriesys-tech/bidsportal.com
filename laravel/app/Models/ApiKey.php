<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{
    protected $fillable = [
        'api_key'
    ];

    protected $primaryKey = 'api_key_id';
}
