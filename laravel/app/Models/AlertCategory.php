<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AlertCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'alert_id',
        'category_id'
    ];

    protected $primaryKey = 'alert_category_id';
}
