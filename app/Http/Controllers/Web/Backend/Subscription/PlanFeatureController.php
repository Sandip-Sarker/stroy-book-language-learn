<?php

namespace App\Http\Controllers\Web\Backend\Subscription;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\PlanFeature;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PlanFeatureController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PlanFeature::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('plan_name', function ($data) {
                    return $data->plan->name;
                })   ->addColumn('plan_price', function ($data) {
                    return $data->plan->price;
                })
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group">
                                <button class="btn btn-primary-gradient" onclick="openEditModal('.$data->id.')">
                                    <i class="fe fe-edit"></i>
                                </button>
                                <a href="#" type="button" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger-gradient fs-14 text-white delete-icn" title="Delete">
                                    <i class="fe fe-trash"></i>
                                </a>
                            </div>';
                })
                ->rawColumns(['action', 'plan_name', 'plan_price'])
                ->make();
        }
        $plans = Plan::all();
        return view('backend.layouts.plan.feature', compact('plans'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'feature'      => 'required',
        ]);

        try {
            PlanFeature::create([
                'plan_id'   => $request->plan_id,
                'feature'   => $request->feature,
            ]);

            return response()->json([
                't-success' => true,
                'message'   => 'Plan Created successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                't-success' => false,
                'message'   => 'Failed to create plan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        $feature = PlanFeature::findOrFail($id);
        return response()->json($feature);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'feature' => 'required|string|max:255',
        ]);

        try {
            $planFeature = PlanFeature::findOrFail($id);

            $planFeature->update([
                'plan_id' => $request->plan_id,
                'feature' => $request->feature,
            ]);

            return response()->json([
                't-success' => true,
                'message'   => 'Plan feature updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                't-success' => false,
                'message'   => 'Failed to update plan feature'
            ], 500);
        }
    }


    public function destroy($id)
    {
        $plan = PlanFeature::findOrFail($id);
        $plan->delete();
        return response()->json([
            't-success' => true,
            'message'   => 'Deleted successfully.',
        ]);
    }


}
