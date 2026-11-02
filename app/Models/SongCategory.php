<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SongCategory extends Model
{
    protected $fillable = ['name', 'status', 'image'];

    protected $casts = [
        'name' => 'string',
        'image' => 'string',
        'status' => 'string',
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
