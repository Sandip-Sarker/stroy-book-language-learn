<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable =[
        'question',
        'answer',
        'status'
    ];

    protected $casts = [
        'question'          => 'string',
        'answer'            => 'string',
        'status'            => 'string'
    ];

    protected $hidden = ['created_at','updated_at'];


}
