<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdminSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_trial',
        'no_of_days'
    ];

    protected $primaryKey = 'admin_setting_id';
}
