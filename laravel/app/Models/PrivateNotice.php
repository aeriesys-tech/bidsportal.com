<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrivateNotice extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'private_notice_name',
        'sort',
        'background_color'
    ];

    protected $primaryKey = 'private_notice_id';
}
