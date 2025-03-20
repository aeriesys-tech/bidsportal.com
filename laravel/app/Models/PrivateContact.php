<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrivateContact extends Model
{
    use HasFactory;
    protected $fillable = [
    	'private_tender_id',
    	'type',
    	'email',
    	'phone',
    	'title',
    	'full_name'
    ];

    protected $primaryKey = 'private_contact_id';
}
