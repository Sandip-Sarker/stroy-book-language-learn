<?php

namespace App\Http\Controllers\API\Profile;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    use ApiResponse;

    public function notificationSetting(Request $request)
    {
        $request->validate([
            'notification' => 'required|boolean',
        ]);

         $user = Auth::user()->update($request->only(['notification']));


        if ($user) {
            return $this->success('Notification Setting updated successfully',$user, 200);
        }
        else {
            return $this->error('Notification Setting not updated');
        }

    }
}
