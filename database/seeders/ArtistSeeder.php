<?php

namespace Database\Seeders;

use App\Models\Artist;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArtistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $artists = [
            [
                'name' => 'John lennon'
            ],
            [
                'name' => 'Edith Piaf'
            ],
            [
                'name' => 'Consuelo Valazquez'
            ],
        ];

        foreach ($artists as $artist) {
            Artist::create($artist);
        }
    }
}
