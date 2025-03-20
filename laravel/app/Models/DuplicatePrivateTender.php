<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DuplicatePrivateTender extends Model
{
    use HasFactory;
    
    protected $fillable = [
    	'tender_no',
    	'title',
    	'posted_date',
    	'tender_url'
    ];

    protected $primaryKey = 'duplicate_private_tender_id';
}
