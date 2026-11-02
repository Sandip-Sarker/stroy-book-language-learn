<?php

namespace Database\Seeders;

use App\Models\SongCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SongCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Pop',
                'image' => 'frontend\no-image.jpg'
            ],
            [
                'name' => 'Ballad',
                'image' => 'frontend\no-image.jpg'
            ],
            [
                'name' => 'Rock',
                'image' => 'frontend\no-image.jpg'
            ],
            [
                'name' => 'Anime',
                'image' => 'frontend\no-image.jpg'
            ],
            [
                'name' => 'Electronic',
                'image' => 'frontend\no-image.jpg'
            ],
            [
                'name' => 'R&B',
                'image' => 'frontend\no-image.jpg'
            ],
            [
                'name' => 'Hip-Hop',
                'image' => 'frontend\no-image.jpg'
            ],
        ];

        foreach ($categories as $category) {
            SongCategory::create($category);
        }
    }
}
