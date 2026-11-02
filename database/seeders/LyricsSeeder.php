<?php

namespace Database\Seeders;

use App\Models\Lyrics;
use App\Models\Song;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LyricsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lyrics = [
            [
                'song_id' => 1,
                'eng_lang' => 'Shuffle Shuffle Shuffle',
                'other_lang' => 'Barajar, barajar, barajar',
                'start_time' => '1',
                'end_time' => '10',
            ],
            [
                'song_id' => 1,
                'eng_lang' => "What a deck of cards we've been dealt",
                'other_lang' => 'Vaya baraja de cartas que nos han tocado',
                'start_time' => '11',
                'end_time' => '20',
            ],
            [
                'song_id' => 1,
                'eng_lang' => "We lay it all down",
                'other_lang' => 'Lo ponemos todo sobre la mesa',
                'start_time' => '21',
                'end_time' => '30',
            ],
            [
                'song_id' => 2,
                'eng_lang' => 'Shuffle Shuffle Shuffle',
                'other_lang' => 'Barajar, barajar, barajar',
                'start_time' => '1',
                'end_time' => '10',
            ],
            [
                'song_id' => 2,
                'eng_lang' => "What a deck of cards we've been dealt",
                'other_lang' => 'Vaya baraja de cartas que nos han tocado',
                'start_time' => '11',
                'end_time' => '20',
            ],
            [
                'song_id' => 2,
                'eng_lang' => "We lay it all down",
                'other_lang' => 'Lo ponemos todo sobre la mesa',
                'start_time' => '21',
                'end_time' => '30',
            ],
            [
                'song_id' => 3,
                'eng_lang' => 'Shuffle Shuffle Shuffle',
                'other_lang' => 'Barajar, barajar, barajar',
                'start_time' => '1',
                'end_time' => '10',
            ],
            [
                'song_id' => 3,
                'eng_lang' => "What a deck of cards we've been dealt",
                'other_lang' => 'Vaya baraja de cartas que nos han tocado',
                'start_time' => '11',
                'end_time' => '20',
            ],
            [
                'song_id' => 3,
                'eng_lang' => "We lay it all down",
                'other_lang' => 'Lo ponemos todo sobre la mesa',
                'start_time' => '21',
                'end_time' => '30',
            ],
        ];

        foreach ($lyrics as $lyric) {
            Lyrics::create($lyric);
        }
    }
}
