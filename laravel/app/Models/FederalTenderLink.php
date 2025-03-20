<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FederalTenderLink extends Model
{
	use HasFactory;
    protected $fillable = [
    	'federal_tender_id',
        'rel',
        'href'
    ];

    protected $primaryKey = 'federal_tender_link_id';
}
