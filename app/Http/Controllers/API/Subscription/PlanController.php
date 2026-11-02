<?php

namespace App\Http\Controllers\API\Subscription;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    use ApiResponse;

    public function plan()
    {
        $plan = Plan::with('planFeatures')->get();
        return $this->success('Data get successfully',$plan, 200);
    }
}
