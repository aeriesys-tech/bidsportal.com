<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StateContact extends Model
{
    use HasFactory;
    protected $fillable = [
    	'state_tender_id',
    	'type',
    	'email',
    	'phone',
    	'title',
    	'full_name'
    ];

    protected $primaryKey = 'state_contact_id';

    public function StateTender()
    {
        return $this->hasOne('App\Models\StateTender','state_tender_id','state_tender_id');
    }
}
