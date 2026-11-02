<?php

namespace App\Http\Controllers\Web\Backend\Subscription;

use App\Models\Plan;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Null_;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PlanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Plan::all();
            return DataTables::of($data)
                ->addIndexColumn()
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
                ->rawColumns(['action'])
                ->make();
        }
        return view('backend.layouts.plan.index');
    }


    public function store(Request $request)
    {

        $request->validate([
            'name'      => 'required|unique:plans,name',
            'price'     => 'required|numeric',
            'type'      => 'required|in:subscription,one_time',
            'interval'  => 'nullable', // one_time এ লাগবে না
        ]);

        try {

            $paypalProductId = null;
            $paypalPlanId    = null;

            // Only Subscription needs PayPal Product & Plan
            if ($request->type === 'subscription') {

                $provider = new PayPalClient;
                $provider->setApiCredentials(config('paypal'));
                $provider->getAccessToken();

                // Create PayPal Product
                $product = $provider->createProduct([
                    'name'        => $request->name,
                    'description' => $request->description ?? $request->name,
                    'type'        => 'SERVICE',
                    'category'    => 'SOFTWARE'
                ]);


                if (!isset($product['id'])) {
                    \Log::error('PayPal Product creation failed:', $product);
                    throw new \Exception('PayPal Product creation failed: ' . json_encode($product));
                }

                $paypalProductId = $product['id'];

                // Create PayPal Plan
                $paypalPlan = $provider->createPlan([
                    'product_id' => $paypalProductId,
                    'name'       => $request->name . ' Plan',
                    'status'     => 'ACTIVE',
                    'billing_cycles' => [[
                        'frequency' => [
                            'interval_unit'  => strtoupper($request->interval), // MONTH
                            'interval_count'=> 1
                        ],
                        'tenure_type' => 'REGULAR',
                        'sequence'    => 1,
                        'total_cycles'=> 0,
                        'pricing_scheme' => [
                            'fixed_price' => [
                                'value'         => $request->price,
                                'currency_code' => 'USD'
                            ]
                        ]
                    ]],
                    'payment_preferences' => [
                        'auto_bill_outstanding' => true,
                        'payment_failure_threshold' => 3
                    ]
                ]);

                // Response check করো
                if (!isset($paypalPlan['id'])) {
                    \Log::error('PayPal Plan creation failed:', $paypalPlan);
                    throw new \Exception('PayPal Plan creation failed: ' . json_encode($paypalPlan));
                }

                $paypalPlanId = $paypalPlan['id'];
            }




            // Create Plan in DB
            Plan::create([
                'name'              => $request->name,
                'description'       => $request->description ?? null,
                'price'             => $request->price,
                'type'              => $request->type,
                'interval'          => $request->interval,
                'status'            => 'Active',
                'paypal_product_id' => $paypalProductId,
                'paypal_plan_id'    => $paypalPlanId,
            ]);

            return response()->json([
                't-success' => true,
                'message'   => 'Plan created successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                't-success' => false,
                'message'   => $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        $plan = Plan::findOrFail($id);
        return response()->json($plan);
    }

    // plan update with PayPal plan old disable and new create
    public function update(Request $request, $id)
    {

        $plan = Plan::findOrFail($id);

        $request->validate([
            'name'     => 'required|unique:plans,name,' . $id,
            'price'    => 'required|numeric',
            'type'     => 'required|in:subscription,one_time',
            'interval' => 'required_if:type,subscription|in:MONTH,YEAR',
        ]);

        try {
            $priceChanged       = $plan->price != $request->price;
            $newPaypalPlanId    = $plan->paypal_plan_id;

            // Only for subscription plans
            if ($plan->type === 'subscription') {

                $provider = new PayPalClient;
                $provider->setApiCredentials(config('paypal'));
                $provider->getAccessToken();

                // If PayPal plan exists & price changed
                if ($plan->paypal_plan_id && $priceChanged) {
                    // Disable old plan
                    $provider->updatePlan($plan->paypal_plan_id, [
                        ['op'=>'replace','path'=>'/status','value'=>'INACTIVE']
                    ]);

                    // Create new PayPal plan
                    $newPlan = $provider->createPlan([
                        'product_id' => $plan->paypal_product_id,
                        'name' => $request->name . ' Plan',
                        'status' => 'ACTIVE',
                        'billing_cycles' => [[
                            'frequency' => [
                                'interval_unit' => $request->interval,
                                'interval_count'=> 1
                            ],
                            'tenure_type' => 'REGULAR',
                            'sequence' => 1,
                            'total_cycles' => 0,
                            'pricing_scheme' => [
                                'fixed_price'=> [
                                    'value' => (string) $request->price,
                                    'currency_code' => 'USD'
                                ]
                            ]
                        ]],
                        'payment_preferences' => [
                            'auto_bill_outstanding' => true,
                            'setup_fee' => [
                                'value' => '0',
                                'currency_code' => 'USD'
                            ],
                            'setup_fee_failure_action' => 'CONTINUE',
                            'payment_failure_threshold' => 3
                        ]
                    ]);

                    $newPaypalPlanId = $newPlan['id'];
                }
            }

            // Update DB
            $plan->update([
                'name'           => $request->name,
                'price'          => $request->price,
                'type'           => $request->type,
                'interval'       => $request->interval,
                'paypal_plan_id' => $newPaypalPlanId
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Plan updated successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // plan delete with PayPal plan disable
    public function destroy($id)
    {
        $plan = Plan::findOrFail($id);

        if ($plan->paypal_plan_id) {

            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $provider->getAccessToken();


            $provider->updatePlan($plan->paypal_plan_id, [
                [
                    'op' => 'replace',
                    'path' => '/status',
                    'value' => 'INACTIVE'
                ]
            ]);

        }

        $plan->delete();

        return response()->json([
            't-success' => true,
            'message'   => 'Deleted successfully.',
        ]);
    }

}
