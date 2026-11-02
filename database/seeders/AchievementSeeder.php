<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $achievements = [
            [
                'title' => 'Bronze Listener',
                'image' => 'backend/images/achievement/bronze.png',
                'quiz_num' => 5,
                'xp_num' => 10
            ],
            [
                'title' => 'Silver Singer',
                'image' => 'backend/images/achievement/silver.png',
                'quiz_num' => 10,
                'xp_num' => 10
            ],
            [
                'title' => 'Gold Performer',
                'image' => 'backend/images/achievement/gold.png',
                'quiz_num' => 15,
                'xp_num' => 10
            ],
        ];

        foreach ($achievements as $achievement) {
            Achievement::create($achievement);
        }
    }
}
