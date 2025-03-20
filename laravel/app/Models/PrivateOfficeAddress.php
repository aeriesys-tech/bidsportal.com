<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrivateOfficeAddress extends Model
{
    use HasFactory;

    protected $fillable = [
    	'private_tender_id',
    	'city',
    	'state',
    	'country',
    	'zip_code'
    ];

    protected $primaryKey = 'private_office_address_id';
}
