<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FederalOfficeAddress extends Model
{
    use HasFactory;

    protected $fillable = [
    	'federal_tender_id',
    	'city',
    	'state',
    	'country',
    	'zip_code'
    ];

    protected $primaryKey = 'federal_office_address_id';
}
