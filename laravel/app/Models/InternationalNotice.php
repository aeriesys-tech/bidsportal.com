<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InternationalNotice extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'international_notice_name',
        'sort',
        'background_color'
    ];

    protected $primaryKey = 'international_notice_id';
}
