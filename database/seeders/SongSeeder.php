<?php

namespace Database\Seeders;

use App\Models\Song;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $songs = [
            [
                'language_id' => 1,
                'song_category_id' => 1,
                'artist_id' => 1,
                'title' => 'Imagine',
                'short_description' => 'A timeless classic about peace and unity',
                'image' => 'frontend\no-image.jpg',
                'difficult' => 'Beginner',
            ],
            [
                'language_id' => 2,
                'song_category_id' => 2,
                'artist_id' => 2,
                'title' => 'Besame Mucho',
                'short_description' => 'A romantic bolero that has captured hearts worldwide',
                'image' => 'frontend\no-image.jpg',
                'audio' => 'backend\audio\song.mp3',
                'difficult' => 'Intermediate',
            ],
            [
                'language_id' => 3,
                'song_category_id' => 3,
                'artist_id' => 3,
                'title' => 'La Vie en Rose',
                'short_description' => 'An iconic French Song',
                'image' => 'frontend\no-image.jpg',
                'audio' => 'backend\audio\song1.mp3',
                'difficult' => 'Intermediate',
            ],
        ];

        foreach ($songs as $song) {
            Song::create($song);
        }
    }
}
