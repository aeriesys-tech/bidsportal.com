<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlertNaics extends Model
{
    use HasFactory;
    protected $fillable = [
		'first_name',
        'last_name',
        'email',
        'mobile1',
        'mobile2',
        'password',
        'role',
        'created_on',
        'last_login',
        'last_seen',
        'last_edited',
        'status',
        'real_password'
    ];

    protected $primaryKey = 'admin_id';
}
