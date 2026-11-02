<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
    protected $fillable = [
        'name'
    ];

    protected $casts = [
        'name' => 'string'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function faq()
    {
        return $this->hasMany(Faq::class);
    }
}
