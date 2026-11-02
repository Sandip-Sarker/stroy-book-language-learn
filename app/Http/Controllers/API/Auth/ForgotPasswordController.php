<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponse;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    use ApiResponse;


    public function send_otp(User $user,$mailType = 'verify')
    {
        $otp        = (new Otp)->generate($user->email, 'numeric', 6, 60);
        $message    = $mailType === 'verify' ? 'Verify Your Email Address' : 'Reset Your Password';
        Mail::to($user->email)->send(new \App\Mail\OTP($otp->token,$user,$message,$mailType));
        return $otp;
    }

    public function forgotPassword(Request $request)
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'email' => 'required|string|email',
            ]);

            $user = User::where('email', $request->email)->first();

            if(!$user){
                return $this->error("User Not Found", 404);
            }

            $otp                        = $this->send_otp($user);
            $user->email_verified_at      = null;
            $user->save();

            DB::commit();
            return $this->success('OTP send successfully.',['otp' => $otp],202);
        }catch (\Exception $exception){
            DB::rollBack();
            return $this->error($exception->getMessage(), 500);
        }
    }
}
