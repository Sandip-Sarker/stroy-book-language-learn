<?php

namespace Database\Seeders;

use App\Models\UserAchievement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserAchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'user_id' => 2,
                'achievement_id' => 1,
            ],
            [
                'user_id' => 2,
                'achievement_id' => 2,
            ],
            [
                'user_id' => 2,
                'achievement_id' => 3,
            ],
        ] ;

        foreach ($datas as $data) {
            UserAchievement::create($data);
        }
    }
}
