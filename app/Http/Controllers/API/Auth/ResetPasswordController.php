<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResetPasswordController extends Controller
{
    use ApiResponse;

    public function resetPassword(Request $request)
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'email'     => 'required|string|email',
                'password'  => 'required|string|confirmed',
            ]);

            $user           = User::where('email', $request->email)->first();
            $user->password = $request->input('password');
            $user->save();

            DB::commit();
            return $this->success('Password reset successfully.',$user, 200);
        }catch (\Exception $exception){
            DB::rollBack();
            return $this->error($exception->getMessage(), 500);
        }
    }
}
