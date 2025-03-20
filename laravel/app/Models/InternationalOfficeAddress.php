<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InternationalOfficeAddress extends Model
{
    use HasFactory;
    protected $fillable = [
    	'international_tender_id',
    	'city',
    	'state',
    	'country',
    	'zip_code'
    ];

    protected $primaryKey = 'international_office_address_id';
}
