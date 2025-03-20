<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserPrivateInterest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'private_tender_id',
        'interest_type'
    ];

    protected $primaryKey = 'user_private_interest_id';

    public function User()
    {
		return $this->belongsTo(User::class, 'user_id');
    }
}
