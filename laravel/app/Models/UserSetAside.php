<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSetAside extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'set_aside_id'
    ];

    protected $primaryKey = 'user_set_aside_id';
}
