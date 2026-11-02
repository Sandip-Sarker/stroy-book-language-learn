<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lyrics extends Model
{
    protected $fillable = [
        'song_id',
        'eng_lang',
        'other_lang',
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'song_id'       => 'integer',
        'eng_lang'      => 'string',
        'other_lang'    => 'string',
        'start_time'    => 'string',
        'end_time'      => 'string',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function song()
    {
        return $this->belongsTo(Song::class);
    }

    public function toArray(): array
    {
        return [
            'id'         => $this->id,
            'eng_lang'   => $this->eng_lang,
            'other_lang' => $this->other_lang,
            'duration' => [
                'start_time' => $this->start_time,
                'end_time'   => $this->end_time,
            ],
        ];
    }
}
