<?php

namespace Database\Seeders;

use App\Models\QuizOption;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuizOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $answers = [
            [
                'quiz_question_id'  => 1,
                'option_label' => 'A',
                'option_text' => 'Au revoir',
            ],
            [
                'quiz_question_id'  => 1,
                'option_label' => 'B',
                'option_text' => 'Bonjour',
                'is_correct' => true,
            ],
            [
                'quiz_question_id'  => 1,
                'option_label' => 'C',
                'option_text' => 'Merci',
            ],
            [
                'quiz_question_id'  => 1,
                'option_label' => 'D',
                'option_text' => "S'il vous plait",
            ],
            [
                'quiz_question_id'  => 2,
                'option_label' => 'A',
                'option_text' => 'To Shuffle',
                'is_correct' => true,
            ],
            [
                'quiz_question_id'  => 2,
                'option_label' => 'B',
                'option_text' => 'To Dance',
            ],
            [
                'quiz_question_id'  => 2,
                'option_label' => 'C',
                'option_text' => 'To Sing',
            ],
            [
                'quiz_question_id'  => 2,
                'option_label' => 'D',
                'option_text' => "To Jump",
            ],
            [
                'quiz_question_id'  => 5,
                'option_label' => 'A',
                'option_text' => 'Au revoir',
            ],
            [
                'quiz_question_id'  => 5,
                'option_label' => 'B',
                'option_text' => 'Bonjour',
                'is_correct' => true,
            ],
            [
                'quiz_question_id'  => 5,
                'option_label' => 'C',
                'option_text' => 'Merci',
            ],
            [
                'quiz_question_id'  => 5,
                'option_label' => 'D',
                'option_text' => "S'il vous plait",
            ],
            [
                'quiz_question_id'  => 6,
                'option_label' => 'A',
                'option_text' => 'To Shuffle',
                'is_correct' => true,
            ],
            [
                'quiz_question_id'  => 6,
                'option_label' => 'B',
                'option_text' => 'To Dance',
            ],
            [
                'quiz_question_id'  => 6,
                'option_label' => 'C',
                'option_text' => 'To Sing',
            ],
            [
                'quiz_question_id'  => 6,
                'option_label' => 'D',
                'option_text' => "To Jump",
            ],
        ];

        foreach ($answers as $answer) {
            QuizOption::create($answer);
        }
    }
}
