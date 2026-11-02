<?php

namespace App\Http\Controllers\Web\Backend\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class UserSubscriptionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = UserSubscription::where('status', 'ACTIVE')->latest()
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user_name', function ($data) {
                    return $data->user->name;
                })
                ->addColumn('plan_name', function ($data) {
                    return $data->plan->name;
                })
                ->addColumn('plan_price', function ($data) {
                    return $data->plan->price;
                })
                ->addColumn('subscription_id', function ($data) {
                    if ($data->paypal_subscription_id) {
                        return $data->paypal_subscription_id . '(Subscription ID)';
                    }else{
                        return $data->paypal_order_id . '(Order ID)';
                    }
                })
                ->addColumn('status', function ($data) {
                    if ($data->status == 'ACTIVE') {
                        return '<span class="badge bg-success-gradient p-3">Active</span>';
                    }
                    return '<span class="badge bg-danger-gradient p-3">Inactive</span>';
                })
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <a href="#" type="button" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger-gradient fs-14 text-white delete-icn" title="Delete">
                                    <i class="fe fe-trash"></i>
                                </a>
                            </div>';
                })
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="user-checkbox" value="' . $row->id . '">';
                })
                ->rawColumns(['user_name','plan_name','plan_price', 'action', 'checkbox', 'status'])
                ->make();
        }
        return view('backend.layouts.user-subscription.index');
    }

    public function destroy($id)
    {
        $plan = UserSubscription::findOrFail($id);
        $plan->delete();
        return response()->json([
            't-success' => true,
            'message'   => 'Deleted successfully.',
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        UserSubscription::whereIn('id', $ids)->delete();
        return response()->json([
            't-success' => true,
            'message'   => 'Selected data deleted successfully.'
        ]);
    }

}
