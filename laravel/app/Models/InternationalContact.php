<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InternationalContact extends Model
{
    use HasFactory;
    protected $fillable = [
    	'international_tender_id',
    	'type',
    	'email',
    	'phone',
    	'title',
    	'full_name'
    ];

    protected $primaryKey = 'international_contact_id';
}
