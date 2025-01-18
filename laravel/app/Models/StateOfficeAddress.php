<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StateOfficeAddress extends Model
{
    use HasFactory;

    protected $fillable = [
    	'state_tender_id',
    	'city',
    	'state',
    	'country',
    	'zip_code'
    ];

    protected $primaryKey = 'state_office_address_id';

    public function StateTender()
    {
        return $this->hasOne('App\Models\StateTender','state_tender_id','state_tender_id');
    }
}
