<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizAnswer extends Model
{
    protected $fillable = [
        'user_id',
        'song_id',
        'quiz_question_id',
        'quiz_option_id',
        'is_correct',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'song_id' => 'integer',
        'quiz_question_id' => 'integer',
        'quiz_option_id' => 'integer',
        'is_correct' => 'boolean',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quiz_question()
    {
        return $this->belongsTo(QuizQuestion::class);
    }

    public function quiz_option()
    {
        return $this->belongsTo(QuizOption::class);
    }
}
