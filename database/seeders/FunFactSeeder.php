<?php

namespace Database\Seeders;

use App\Models\FunFact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FunFactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'language_id' => 1,
                'title' => 'Fun Fact One Title',
                'description' => 'Fun Fact One Description',
                'image' => null
            ],
            [
                'language_id' => 2,
                'title' => 'Fun Fact Two Title',
                'description' => 'Fun Fact Two Description',
                'image' => null
            ],
            [
                'language_id' => 3,
                'title' => 'Fun Fact Three Title',
                'description' => 'Fun Fact Three Description',
                'image' => null
            ],
            [
                'language_id' => 1,
                'title' => 'Fun Fact Four Title',
                'description' => 'Fun Fact Four Description',
                'image' => null
            ]
        ];

        foreach ($datas as $data) {
            FunFact::create($data);
        }
    }
}
