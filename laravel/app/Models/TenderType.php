<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TenderType extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'tender_type_name',
        'sort'
    ];

    protected $primaryKey = 'tender_type_id';
}
