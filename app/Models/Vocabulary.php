<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vocabulary extends Model
{
    protected $fillable = [
        'song_id',
        'word',
        'meaning',
        'example',
    ];

    protected $casts = [
        'song_id' => 'integer',
        'word' => 'string',
        'meaning' => 'string',
        'example' => 'string',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function song()
    {
        return $this->belongsTo(Song::class);
    }
}
