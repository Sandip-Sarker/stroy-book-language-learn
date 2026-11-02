<?php

namespace App\Http\Controllers\Web\Backend\User;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserDonationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Donation::where('status', 'COMPLETED')->latest()
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user_name', function ($data) {
                    return $data->user->name;
                })
                ->addColumn('status', function ($data) {
                    if ($data->status == 'COMPLETED') {
                        return '<span class="badge bg-success-gradient p-3">Paid</span>';
                    }
                    return '<span class="badge bg-danger-gradient p-3">Not Paid</span>';
                })
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <a href="#" type="button" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger-gradient fs-14 text-white delete-icn" title="Delete">
                                    <i class="fe fe-trash"></i>
                                </a>
                            </div>';
                })
                ->rawColumns(['user_name','action','status'])
                ->make();
        }
        return view('backend.layouts.user-subscription.donation');
    }

    public function destroy($id)
    {
        $plan = Donation::findOrFail($id);
        $plan->delete();
        return response()->json([
            't-success' => true,
            'message'   => 'Deleted successfully.',
        ]);
    }

}
