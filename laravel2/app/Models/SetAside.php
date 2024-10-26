<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SetAside extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'set_aside_name',
        'sort'
    ];

    protected $primaryKey = 'set_aside_id';
}
