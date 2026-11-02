<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SystemSetting::create([
            'title' => 'Lingual Jams',
            'system_name' => 'Lingual Jams',
            'email' => 'lingualjams@xyz.com',
            'number' => '5873515720',
            'logo' => null,
            'favicon' => null,
            'address' => 'USA',
            'copyright_text' => 'Copyright 2026. All Rights Reserved. Powered by One Pro.',
            'description' => null,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ]);
    }
}
