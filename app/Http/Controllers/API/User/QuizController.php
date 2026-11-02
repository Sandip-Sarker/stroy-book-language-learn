<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\QuizAnswer;
use App\Models\QuizOption;
use App\Models\Achievement;
use App\Models\UserAchievement;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    use ApiResponse;

    public function userSubmitQiz(Request $request)
    {
        $option = QuizOption::findOrFail($request->quiz_option_id);
        $user = auth()->user();

        // Check if there's already a correct answer for this question by the user
        $alreadyCorrect = QuizAnswer::where('user_id', $user->id)
            ->where('quiz_question_id', $request->quiz_question_id)
            ->where('is_correct', true)
            ->exists();

        $answer = QuizAnswer::updateOrCreate(
            [
                'user_id'           => $user->id,
                'song_id'           => $request->song_id,
                'quiz_question_id'  => $request->quiz_question_id,
            ],
            [
                'quiz_option_id' => $request->quiz_option_id,
                'is_correct'     => $option->is_correct,
            ]
        );

        if (!$answer){
            return $this->error('Data not saved', 404);
        }

        // If the answer is correct and they hadn't answered it correctly before, award 25 XP
        if ($option->is_correct && !$alreadyCorrect) {
            $user->increment('xp', 25);
            $user->refresh();

            // Fetch newly unlocked achievements based on user's total XP
            $earnedAchievementIds = UserAchievement::where('user_id', $user->id)
                ->pluck('achievement_id')
                ->toArray();

            $newAchievements = Achievement::whereNotIn('id', $earnedAchievementIds)
                ->where('xp_num', '<=', $user->xp)
                ->get();

            foreach ($newAchievements as $achievement) {
                UserAchievement::create([
                    'user_id'        => $user->id,
                    'achievement_id' => $achievement->id,
                ]);
            }
        }

        $data = [
            'answer' => $answer,
            'correct' => $option->is_correct ? 'yes' : 'no',
            'message' => $option->is_correct
                ? 'Correct answer 🎉'
                : 'Wrong answer ❌'
        ];

        return $this->success('Data save successfully', $data, 200);

    }
}
