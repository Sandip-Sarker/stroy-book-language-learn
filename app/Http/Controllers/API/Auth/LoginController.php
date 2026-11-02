<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Twilio\Rest\Client;


class LoginController extends Controller
{
    use ApiResponse;

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email'    => 'required|email',
                'password' => 'required',
            ]);
            if (!Auth::attempt($request->only('email', 'password'))) {
                return $this->error('Invalid credentials', 401);
            }

            $user = Auth::user();

            // Token create
            $token    = $user->createToken('AuthToken')->plainTextToken;

            $data = [
                'status'      => true,
                'token_type'  => 'Bearer',
                'token'       => $token,
                'remember_me' => $request->boolean('remember'),
                'user'        => $user,
            ];

            return $this->success("Login Successfully", $data, 200);

        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), 500);
        }
    }

}
