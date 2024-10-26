<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Psc extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'psc_parent_id',
        'psc_code',
        'psc_description'
    ];

    protected $primaryKey = 'psc_id';

    public function Psc()
    {
        return $this->hasMany('App\Models\Psc','psc_parent_id','psc_id');
    }
}
