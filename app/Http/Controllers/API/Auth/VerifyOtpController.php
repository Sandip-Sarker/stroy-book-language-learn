<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponse;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class VerifyOtpController extends Controller
{
    use ApiResponse;

    public function send_otp(User $user,$mailType = 'verify')
    {
        $otp        = (new Otp)->generate($user->email, 'numeric', 6, 60);
        $message    = $mailType === 'verify' ? 'Verify Your Email Address' : 'Reset Your Password';
        Mail::to($user->email)->send(new \App\Mail\OTP($otp->token,$user,$message,$mailType));
        return $otp;
    }


    public function verifyForgotOtp(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'email' => 'required|exists:users,email',
                'otp'   => 'required',
            ]);

            $email  = $request->get('email');
            $otp    = $request->get('otp');

            $user = User::where('email', $email)->first();

            if (!$user) {
                return $this->error('User not found', 404);
            }

            // validate OTP
            $verify = (new Otp)->validate($email, $otp);

            if ($verify->status == false) {
                return $this->error($verify->message, 400);
            }

            $user->email_verified_at = now();
            $user->save();

            DB::commit();
            return $this->success('OTP verified successfully', [], 200);
        }catch (\Exception $exception){
            DB::rollBack();
            return $this->error($exception->getMessage(), 500);
        }
    }

    public function verifyOtp(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'email' => 'required|exists:users,email',
                'otp'   => 'required',
            ]);

            $email  = $request->get('email');
            $otp    = $request->get('otp');

            $user = User::where('email', $email)->first();

            if (!$user) {
                return $this->error('User not found', 404);
            }

            // validate OTP
            $verify = (new Otp)->validate($email, $otp);

            if ($verify->status == false) {
                return $this->error($verify->message, 400);
            }

            $user->otp_verified_at = now();
            $user->save();

            Auth::login($user);
            $user = Auth::user();

            $data = [
                'status'        => true,
                'token_type'    => 'Bearer',
                'token'         => $user->createToken('AuthToken')->plainTextToken,
                'user'          => $user,
            ];

            DB::commit();
            return $this->success('OTP verified successfully', $data, 200);
        }catch (\Exception $exception){
            DB::rollBack();
            return $this->error($exception->getMessage(), 500);
        }
    }

    public function resendOtp(Request $request)
    {

        $request->validate([
            'email'     => 'required',
        ]);

        $email = $request->input('email');

        try {
            $user = User::where('email', $email)->first();

            if($user){
                $otp                        = $this->send_otp($user);
                $user->email_verified_at      = null;
                $user->save();

                return $this->success('OTP send successfully.',['otp' => $otp],201);
            }else{
                return $this->error('Email not found',404);
            }
        }catch (\Exception $exception){
            return $this->error($exception->getMessage(), 500);
        }
    }

}
