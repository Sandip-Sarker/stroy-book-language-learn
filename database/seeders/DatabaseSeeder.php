<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Artist;
use App\Models\QuizQuestion;
use App\Models\UserAchievement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Disable foreign key checks to prevent issues with deletions
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clear existing data
        DB::table('users')->truncate();
        DB::table('system_settings')->truncate();
        DB::table('mail_settings')->truncate();
        DB::table('dynamic_pages')->truncate();
        DB::table('languages')->truncate();
        DB::table('song_categories')->truncate();
        DB::table('artists')->truncate();
        DB::table('songs')->truncate();
        DB::table('lyrics')->truncate();
        DB::table('vocabularies')->truncate();
        DB::table('quiz_questions')->truncate();
        DB::table('quiz_options')->truncate();
        DB::table('quiz_answers')->truncate();
        DB::table('achievements')->truncate();
        DB::table('user_achievements')->truncate();
        DB::table('fun_facts')->truncate();


        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Call seeders
        $this->call([
            UserSeeder::class,
            SystemSettingSeeder::class,
            MailSettingSeeder::class,
            DynamicPageSeeder::class,
            LanguageSeeder::class,
            SongCategorySeeder::class,
            ArtistSeeder::class,
            SongSeeder::class,
            LyricsSeeder::class,
            VocabularySeeder::class,
            QuizQuestionSeeder::class,
            QuizOptionSeeder::class,
            QuizAnswerSeeder::class,
            AchievementSeeder::class,
            UserAchievementSeeder::class,
            FunFactSeeder::class,
        ]);
    }
}
