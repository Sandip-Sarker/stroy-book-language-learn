<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class FunFact extends Model
{
    protected $fillable = [
        'language_id',
        'title',
        'description',
        'image',
    ];

    protected $casts = [
        'title' => 'string',
        'description' => 'string',
        'image' => 'string',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function language()
    {
        return $this->belongsTo(Language::class);
    }   
    /**
     * Get the thumbnail attribute with URL for API requests.
     */
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn($value) =>
            request()->is('api/*') && ! empty($value)
                ? url(Storage::url($value))
                : $value
        );
    }
}
