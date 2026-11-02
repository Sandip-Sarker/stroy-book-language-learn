<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizQuestion extends Model
{
    protected $fillable = [
        'song_id',
        'question',
    ];

    protected $casts = [
        'song_id' => 'integer',
        'question' => 'string',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function song(): BelongsTo
    {
        return $this->belongsTo(Song::class);
    }

    public function quizOptions()
    {
        return $this->hasMany(QuizOption::class, 'quiz_question_id');
    }
}
