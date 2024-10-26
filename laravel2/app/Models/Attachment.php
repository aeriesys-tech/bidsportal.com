<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attachment extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'name',
        'attachment_size',
        'attachment_date'
    ];

    protected $primaryKey = 'attachment_id';
}
