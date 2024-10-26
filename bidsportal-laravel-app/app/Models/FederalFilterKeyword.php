<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FederalFilterKeyword extends Model
{
    use HasFactory;
    protected $fillable = [
    	'federal_filter_id',
    	'keyword'
    ];

    protected $primaryKey = 'federal_filter_keyword_id';

    public function FederalFilter(){
        return $this->belongsTo('App\Models\FederalFilter', 'federal_filter_id', 'federal_filter_id');
    }
}
