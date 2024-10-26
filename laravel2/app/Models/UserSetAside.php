<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSetAside extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'user_id',
        'set_aside_id'
    ];

    protected $primaryKey = 'user_set_aside_id';
}
