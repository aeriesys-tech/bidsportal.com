<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContractType extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'contract_type',
        'sort'
    ];

    protected $primaryKey = 'contract_type_id';
}
