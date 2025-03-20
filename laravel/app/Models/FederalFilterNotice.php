<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FederalFilterNotice extends Model
{
    use HasFactory;

    protected $fillable = [
    	'federal_filter_id',
    	'federal_notice_id'
    ];

    protected $primaryKey = 'federal_filter_notice_id';
}
