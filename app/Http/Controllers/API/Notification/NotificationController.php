<?php

namespace App\Http\Controllers\API\Notification;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    use ApiResponse;

    public function getNotification()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->latest()->get();

        $data = $notifications->map(function ($notify) {
            return [
                'title'      => $notify->data['title'] ?? '',
                'message'    => $notify->data['message'] ?? '',
                'created_at' => Carbon::parse($notify->created_at)->diffForHumans(),
            ];
        });

        return $this->success('Data get successfully', $data, 200);
    }
}
