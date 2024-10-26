<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FederalContact extends Model
{
    use HasFactory;
    protected $fillable = [
    	'federal_tender_id',
    	'type',
    	'email',
    	'phone',
    	'title',
    	'full_name'
    ];

    protected $primaryKey = 'federal_contact_id';
}
