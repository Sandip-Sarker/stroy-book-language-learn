<?php

namespace Database\Seeders;

use App\Models\QuizAnswer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuizAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $answers = [
            [
                'user_id'           => 1,
                'song_id'           => 1,
                'quiz_question_id'  => 1,
                'quiz_option_id'    => 1,
                'is_correct'        => 1,
            ],
            [
                'user_id'           => 1,
                'song_id'           => 1,
                'quiz_question_id'  => 1,
                'quiz_option_id'    => 1,
                'is_correct'        => 1,
            ],
        ];

        foreach ($answers as $answer) {
            QuizAnswer::create($answer);
        }
    }
}
