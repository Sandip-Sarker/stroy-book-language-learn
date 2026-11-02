<?php

namespace App\Http\Controllers\Web\Backend\Subscription;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\UserSubscription;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class UserSubscriptionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = UserSubscription::with('user', 'plans')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn("user_name", function ($data) {
                    return $data->user->name ?? '';
                })
                ->addColumn("plan_name", function ($data) {
                    return $data->plans->name;
                })
                ->addColumn("start_date", function ($data) {
                    return $data->start_date
                        ? Carbon::parse($data->start_date)->format('d-M-Y, h:i A')
                        : 'N/A';
                })
                ->addColumn("end_date", function ($data) {
                    return $data->end_date
                        ? Carbon::parse($data->end_date)->format('d-M-Y, h:i A')
                        : 'N/A';
                })
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <a href="' . route('user.subscription.show', ['id' => $data->id]) . '" type="button" class="btn btn-info fs-14 text-white edit-icn" title="Details">
                                    <i class="fe fe-eye"></i>
                                </a>
                                <a href="#" type="button" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger fs-14 text-white delete-icn" title="Delete">
                                    <i class="fe fe-trash"></i>
                                </a>
                            </div>';
                })
                ->rawColumns(['action'])
                ->make();
        }
        return view('backend.layouts.user-subscription.index');
    }

    public function show($id)
    {
        $data = UserSubscription::with('user', 'plans')->findOrFail($id);
        return view('backend.layouts.user-subscription.show', compact('data'));
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
}
