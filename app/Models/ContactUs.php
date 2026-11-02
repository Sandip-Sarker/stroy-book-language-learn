<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    protected $fillable = ['user_id','name', 'email', 'phone', 'subject', 'message'];

    protected $casts = [
        'user_id'       =>'integer',
        'name'          =>'string',
        'email'         =>'string',
        'phone'         =>'string',
        'subject'       =>'string',
        'message'       =>'string'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
