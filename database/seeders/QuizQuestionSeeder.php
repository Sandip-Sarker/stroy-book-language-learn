<?php

namespace Database\Seeders;

use App\Models\QuizQuestion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuizQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = [
            [
                'song_id' => 1,
                'question' => "How do you say 'Hello' in French?"
            ],
            [
                'song_id' => 1,
                'question' => "What does 'Barajar' mean?"
            ],
            [
                'song_id' => 2,
                'question' => "How do you say 'Hello' in French?"
            ],
            [
                'song_id' => 2,
                'question' => "What does 'Barajar' mean?"
            ],
            [
                'song_id' => 3,
                'question' => "How do you say 'Hello' in French?"
            ],
            [
                'song_id' => 3,
                'question' => "What does 'Barajar' mean?"
            ],
        ];

        foreach ($questions as $question) {
            QuizQuestion::create($question);
        }
    }
}
