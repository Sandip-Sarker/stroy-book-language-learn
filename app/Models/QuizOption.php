<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizOption extends Model
{
    protected $fillable = [
        'quiz_question_id',
        'option_label',
        'option_text',
        'is_correct',
    ];

    protected $casts = [
        'quiz_question_id'  => 'integer',
        'option_label'      => 'string',
        'option_text'       => 'string',
        'is_correct'        => 'boolean',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

}
