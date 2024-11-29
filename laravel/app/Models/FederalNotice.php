<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FederalNotice extends Model
{
    use HasFactory;
    protected $fillable = [
    	'notice_name',
    	'sort',
    	'background_color'
    ];

    protected $primaryKey = 'federal_notice_id';
}
