<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    use ApiResponse;

    public function register(Request $request)
    {
        try {
            $request->validate([
                'name'      => 'required',
                'email'     => 'required|email|unique:users',
                'password'  => 'required',
            ]);

            $user = User::create([
                'name'              => $request->input('name'),
                'email'             => $request->input('email'),
                'password'          => $request->input('password'),
            ]);

            if (!$user) {
                return $this->error('User not created', 200, []);
            }

            return $this->success('Registration Successfully.', $user, 200);
        }catch (\Exception $exception){
            return $this->error($exception->getMessage(), 500);
        }
    }

}
