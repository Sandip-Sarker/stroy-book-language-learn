<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    use ApiResponse;

    public function logout(Request $request)
    {
        try {
            // Delete the current user’s token
            $request->user()->currentAccessToken()->delete();
            return $this->ok('Logged out successfully.', 200);
        }catch (\Exception $exception){
            return $this->error($exception->getMessage(),500);
        }
    }
}
