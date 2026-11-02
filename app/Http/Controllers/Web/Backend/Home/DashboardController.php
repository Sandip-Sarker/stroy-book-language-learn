<?php

namespace App\Http\Controllers\Web\Backend\Home;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Order;
use App\Models\User;
use App\Models\Verificaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the dashboard page.
     *
     * @return View
     */


    public function index(): View
    {
        if (Auth::check() && Auth::user()->role == 'Admin') {
            return view('backend.layouts.dashboard.index');
        }else{
            return redirect()->back();
        }
    }
}
