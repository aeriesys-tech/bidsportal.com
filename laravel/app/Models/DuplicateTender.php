<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DuplicateTender extends Model
{
    protected $fillable = [
    	'tender_no',
    	'title',
    	'posted_date',
    	'tender_url'
    ];

    protected $primaryKey = 'duplicate_tender_id';
}
