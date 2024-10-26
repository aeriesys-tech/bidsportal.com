<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NoticeRegion extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'notice_id',
        'region_id'
    ];

    protected $primaryKey = 'notice_region_id';
}
