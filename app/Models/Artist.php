<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    protected $fillable = ['name'];

    protected $casts = [
        'name' => 'string'
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
