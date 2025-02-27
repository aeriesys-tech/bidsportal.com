<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notice extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'notice_name',
        'background_color',
        'sort'
    ];

    protected $primaryKey = 'notice_id';
}
