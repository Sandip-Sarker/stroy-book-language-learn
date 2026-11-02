<?php

namespace Database\Seeders;

use App\Models\Vocabulary;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VocabularySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vocabularies = [
            [
                'song_id' => 1,
                'word' => 'Barajar',
                'meaning' => 'Shuffle',
                'example' => 'Used when mixing cards or things randomly',
            ],
            [
                'song_id' => 1,
                'word' => 'Barajar',
                'meaning' => 'Deck',
                'example' => 'A deck of playing cards',
            ],
            [
                'song_id' => 1,
                'word' => 'Mesa',
                'meaning' => 'Table',
                'example' => "A flat surface, also used in expressions like 'lay it on the table'",
            ],
            [
                'song_id' => 1,
                'word' => 'Tocado',
                'meaning' => 'Dealt/Touched',
                'example' => 'What has been given or assigned to someone',
            ],
            [
                'song_id' => 2,
                'word' => 'Barajar',
                'meaning' => 'Shuffle',
                'example' => 'Used when mixing cards or things randomly',
            ],
            [
                'song_id' => 2,
                'word' => 'Barajar',
                'meaning' => 'Deck',
                'example' => 'A deck of playing cards',
            ],
            [
                'song_id' => 2,
                'word' => 'Mesa',
                'meaning' => 'Table',
                'example' => "A flat surface, also used in expressions like 'lay it on the table'",
            ],
            [
                'song_id' => 2,
                'word' => 'Tocado',
                'meaning' => 'Dealt/Touched',
                'example' => 'What has been given or assigned to someone',
            ],
            [
                'song_id' => 3,
                'word' => 'Barajar',
                'meaning' => 'Shuffle',
                'example' => 'Used when mixing cards or things randomly',
            ],
            [
                'song_id' => 3,
                'word' => 'Barajar',
                'meaning' => 'Deck',
                'example' => 'A deck of playing cards',
            ],
            [
                'song_id' => 3,
                'word' => 'Mesa',
                'meaning' => 'Table',
                'example' => "A flat surface, also used in expressions like 'lay it on the table'",
            ],
            [
                'song_id' => 3,
                'word' => 'Tocado',
                'meaning' => 'Dealt/Touched',
                'example' => 'What has been given or assigned to someone',
            ],
        ];

        foreach ($vocabularies as $vocabulary) {
            Vocabulary::create($vocabulary);
        }
    }
}
