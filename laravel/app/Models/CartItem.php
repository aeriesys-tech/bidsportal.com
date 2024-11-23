<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_item_id',
        'user_id',
        'federal_tender_id',
        'state_tender_id',
        'region',
        'cart_item_date'
    ];

    protected $primaryKey = 'cart_item_id';
}
