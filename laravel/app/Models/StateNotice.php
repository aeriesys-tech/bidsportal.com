<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StateNotice extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'notice_name',
        'sort',
        'background_color'
    ];

    protected $primaryKey = 'state_notice_id';
}
