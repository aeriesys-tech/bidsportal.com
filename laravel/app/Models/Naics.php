<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Naics extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'naics_parent_id',
        'naics_code',
        'naics_description'
    ];

    protected $primaryKey = 'naics_id';

    public function Naics()
    {
        return $this->hasMany('App\Models\Naics','naics_parent_id','naics_id');
    }
}
