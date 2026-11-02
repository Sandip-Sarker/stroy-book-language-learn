<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Achievement extends Model
{
    protected $fillable = ['title', 'image', 'quiz_num', 'xp_num'];

    protected $casts = [
        'image'     => 'string',
        'title'     => 'string',
        'quiz_num'  => 'integer',
        'xp_num'    => 'integer',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'quiz_num',
    ];

    public function getImageAttribute($value){
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }
        if (request()->is('api/*') && !empty($value)) {
            return url(Storage::url($value));
        }
        return $value;
    }
}
