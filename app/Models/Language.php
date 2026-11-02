<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Language extends Model
{
    protected $fillable = [ 'name', 'image'];

    protected $hidden = [ 'created_at', 'updated_at'];

    protected $casts = [
        'name' => 'string',
        'image' => 'string',
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
