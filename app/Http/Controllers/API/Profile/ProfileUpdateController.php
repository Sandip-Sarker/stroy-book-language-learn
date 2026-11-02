<?php

namespace App\Http\Controllers\API\Profile;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\ChooseArtist;
use App\Models\QuizAnswer;
use App\Models\User;
use App\Models\UserAchievement;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\Models\Artist;
use App\Notifications\ChangePasswordNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Hash;

class ProfileUpdateController extends Controller
{

    use ApiResponse;

    public function userDashboard()
    {
        $user               = Auth::user();
        
        // Calculate the XP required for the next achievement level
        $nextAchievement = Achievement::where('xp_num', '>', $user->xp)
                            ->orderBy('xp_num', 'asc')
                            ->first();
        
        $totalXP = $nextAchievement ? $nextAchievement->xp_num : (Achievement::max('xp_num') ?? 100);

        $userAchievement    = UserAchievement::with('achievement')->where('user_id', $user->id)->get();
        $quiz               = QuizAnswer::where('user_id', $user->id)->count();
        $thisWeekQuiz       = QuizAnswer::where('user_id', $user->id)
                            ->whereBetween('created_at', [
                                now()->startOfWeek(),
                                now()->endOfWeek()
                            ])
                            ->count();

        $data = [
            'total_xp_earned'       => $user->xp,
            'total_complete_quiz'   => $quiz,
            'total_this_week_quiz'  => $thisWeekQuiz,
            'total_badge_earned'    => $userAchievement->count(),
            'achievement' => $userAchievement->map(function ($item) {
                return [
                    'title'     => $item->achievement->title ?? null,
                    'image'     => $item->achievement->image ?? null,
                    'quiz_num'  => $item->achievement->quiz_num ?? 0,
                    'xp'        => $item->achievement->xp_num ?? 0,
                ];
            }),
            'user'              => $user,
            'badges'            => Achievement::all(),
        ];

        return $this->ok('Use get successfully', $data, 200);
    }

    public function update(Request $request)
    {

        try {
            DB::beginTransaction();
            $user = Auth::user();

            if ($user) {
                if ($request->hasFile('avatar')) {
                    $filePath = Helper::fileUploadStorage($request->file('avatar'), 'avatar', $user->name);

                    if ($user->avatar) {
                        // Remove base url
                        $oldAvatarPath = str_replace(url('/').'/', '', $user->avatar);
                        Helper::storageDeleteFile($oldAvatarPath, 'public');
                    }

                    $user->avatar = $filePath;
                }

                $user->name     = $request->input('name');
                $user->save();

                DB::commit();
                return $this->ok('Update successfully', $user, 200);
            }else {
                return $this->error('User not found');
            }
        }catch (\Exception $exception){
            DB::rollBack();
            return $this->error($exception->getMessage(), 404);
        }
    }
//
//    public function changePassword(Request $request)
//    {
//        try {
//            DB::beginTransaction();
//
//            $request->validate([
//                'current_password' => 'required',
//                'password' => 'required|string|min:6|confirmed',
//            ]);
//
//            $user       = Auth::user();
//            $password   = $request->input('current_password');
//
//            if (!Hash::check($password, $user->password)) {
//                return $this->error('Current password is incorrect');
//            }
//            $user->password = $request->input('password');
//            $user->save();
//
//            Notification::send($user, new ChangePasswordNotification());
//
//
//            DB::commit();
//            return $this->success("Password changed successfully",[], 200);
//        }catch (\Exception $exception){
//            DB::rollBack();
//            return $this->error($exception->getMessage(), 404);
//        }
//    }
//
//    public function profileDelete(Request $request)
//    {
//        $user = Auth::user();
//
//        if ($user) {
//
//            $user->delete();
//
//            return $this->ok('Account deleted successfully.!');
//        }
//
//        return $this->error('User not found');
//    }
}
