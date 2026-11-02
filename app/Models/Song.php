<?php

namespace App\Models;

use Database\Seeders\QuizOptionSeeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Song extends Model
{
    protected $fillable = [
        'language_id',
        'song_category_id',
        'artist_id',
        'title',
        'short_description',
        'image',
        'difficult',
        'is_exclusive',
        'status',
    ];

    protected $casts = [
        'language_id'       => 'integer',
        'song_category_id'  => 'integer',
        'artist_id'         => 'integer',
        'title'             => 'string',
        'short_description' => 'string',
        'image'             => 'string',
        'difficult'         => 'string',
        'is_exclusive'      => 'integer',
        'status'            => 'string',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    public function category()
    {
        return $this->belongsTo(SongCategory::class, 'song_category_id');
    }

    public function artist()
    {
        return $this->belongsTo(Artist::class, 'artist_id');
    }

    public function lyrics()
    {
        return $this->hasMany(Lyrics::class, 'song_id');
    }

    public function vocabularies()
    {
        return $this->hasMany(Vocabulary::class, 'song_id');
    }

    public function quizQuestions()
    {
        return $this->hasMany(QuizQuestion::class, 'song_id');
    }

    public function getImageAttribute($value){
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }
        if (request()->is('api/*') && !empty($value)) {
            return url(Storage::url($value));
        }
        return $value;
    }

    public function getAudioAttribute($value){
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }
        if (request()->is('api/*') && !empty($value)) {
            return url(Storage::url($value));
        }
        return $value;
    }
}
