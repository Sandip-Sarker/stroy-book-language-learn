<?php

namespace App\Http\Controllers\API\Subscription;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\UserSubscription;
use App\Traits\ApiResponse;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class SubscriptionController extends Controller
{
    use ApiResponse;

    public function create(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
        ]);

        $user = Auth::user();
        $plan = Plan::findOrFail($request->plan_id);

        $subscription = UserSubscription::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'status'  => 'PENDING',
        ]);

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        // ── SUBSCRIPTION PLAN ──────────────────────────
        if ($plan->type === 'subscription') {

            $response = $provider->createSubscription([
                'plan_id'    => $plan->paypal_plan_id,
                'subscriber' => [
                    'name'          => ['given_name' => $user->name, 'surname' => ''],
                    'email_address' => $user->email,
                ],
                'application_context' => [
                    'brand_name' => config('app.name'),
                    'locale'     => 'en-US',
                    // ✅ Backend URL — PayPal redirects here first, then we redirect to frontend
                    'return_url' => config('app.url') . '/api/paypal/subscription/success',
                    'cancel_url' => config('app.url') . '/api/paypal/subscription/cancel',
                ],
            ]);

            $subscription->update([
                'paypal_subscription_id'    => $response['id'],
            ]);

            $approveUrl = collect($response['links'])
                ->where('rel', 'approve')
                ->first()['href'];

            return $this->success('Subscription created successfully', [
                'subscription_id' => $response['id'],
                'approve_url'     => $approveUrl,
                'subscriber'      => $subscription,
            ], 200);

            // ── ONE-TIME / DONATION PLAN ────────────────────
        } else {
            $order = $provider->createOrder([
                'intent'         => 'CAPTURE',
                'purchase_units' => [[
                    'amount' => [
                        'currency_code' => 'USD',
                        'value'         => $plan->price,
                    ],
                ]],
                'application_context' => [
                    'brand_name' => config('app.name'),
                    // ✅ Backend URL — PayPal redirects here first, then we redirect to frontend
                    'return_url' => config('app.url') . '/api/paypal/one-time/success',
                    'cancel_url' => config('app.url') . '/api/paypal/one-time/cancel',
                ],
            ]);

            $subscription->update([
                'paypal_order_id' => $order['id'],
            ]);

            return $this->success('Order created successfully', [
                'order_id'     => $order['id'],
                'approval_url' => collect($order['links'])->where('rel', 'approve')->first()['href'],
                'subscriber'   => $subscription,
            ], 200);
        }
    }


    // USER CANCEL SUBSCRIPTION
    public function cancelSubscription(Request $request)
    {
        $user = Auth::user();

        $subscription = UserSubscription::where('user_id', $user->id)
            ->where('status', 'ACTIVE')
            ->latest()
            ->firstOrFail();
    
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        // PayPal এ cancel করো
        $result = $provider->cancelSubscription(
            $subscription->paypal_subscription_id,
            'User requested cancellation'  // reason
        );

        // srmklive library তে cancelSubscription সফল হলে empty array বা 204 response দেয়
        // error না আসলেই success
        if (empty($result) || !isset($result['error'])) {

            $subscription->update([
                'status'   => 'CANCELLED',
                'end_date' => Carbon::now(),
            ]);

            $user->update([
                'is_premium'        => false,
                'subscription_type' => null,
            ]);

            return $this->success('Subscription cancelled successfully', [], 200);
        }

        return response()->json([
            't-success' => false,
            'message'   => 'Failed to cancel subscription',
            'details'   => $result,
        ], 500);
    }

    // SUBSCRIPTION SUCCESS  (PayPal → Backend → Frontend)
    public function paypalSuccess(Request $request)
    {
        // PayPal passes: ?token=xxx&subscription_id=xxx
        $request->validate([
            'token'           => 'required',
        ]);

        $subscriptionId = $request->subscription_id ?? $request->token;

        $subscription = UserSubscription::where('paypal_subscription_id', $subscriptionId)
        ->orWhere('paypal_subscription_id', $request->token)
        ->firstOrFail();

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $details = $provider->showSubscriptionDetails($subscriptionId);

        // PayPal status just after approval = APPROVAL_PENDING or ACTIVE
        if ($details['status'] === 'ACTIVE') {
            $subscription->update([
                'status'     => 'ACTIVE',
                'start_date' => Carbon::now(),
                'end_date'   => $subscription->plan->interval === 'MONTH'
                                ? Carbon::now()->addMonth()
                                : Carbon::now()->addYear(),
            ]);

            $subscription->user->update([
                'is_premium'        => true,
                'subscription_type' => $subscription->plan->interval,
            ]);

            return redirect(
                config('app.frontend_url') . '/payment/success?status=approved&subscription_id=' . $subscription->id
            );

        } elseif ($details['status'] === 'APPROVAL_PENDING') {
            $subscription->update(['status' => 'PENDING']);

            return redirect(
                config('app.frontend_url') . '/payment/pending?status=pending&subscription_id=' . $subscription->id
            );
        }

        // অন্য সব status — failed redirect
        return redirect(
            config('app.frontend_url') . '/payment/cancel?status=failed&reason=not_active'
        );
    }

    // SUBSCRIPTION CANCEL
    public function paypalCancel(Request $request)
    {
        // PayPal passes: ?token=xxx&subscription_id=xxx (subscription_id may be absent)
        if ($request->subscription_id) {
            UserSubscription::where('paypal_subscription_id', $request->subscription_id)
                ->update(['status' => 'CANCELLED']);
        }

        return redirect(
            config('app.frontend_url') . '/payment/cancel?status=cancelled'
        );
    }

    // ONE-TIME / DONATION SUCCESS
    public function oneTimeSuccess(Request $request)
    {
        // PayPal passes: ?token=xxx (token = order_id)
        $request->validate([
            'token' => 'required',   // token = PayPal Order ID
        ]);

        $subscription = UserSubscription::where(
            'paypal_order_id', $request->token
        )->firstOrFail();

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        // ✅ Capture the payment
        $result = $provider->capturePaymentOrder($request->token);

        if (isset($result['status']) && $result['status'] === 'COMPLETED') {

            $subscription->update([
                'status'            => 'ACTIVE',
                'start_date'        => Carbon::now(),
                'paypal_capture_id' => $result['purchase_units'][0]['payments']['captures'][0]['id'] ?? null,
            ]);

            $subscription->user->update(['is_premium' => true]);

            return redirect(
                config('app.frontend_url') . '/payment/success?status=completed&subscription_id=' . $subscription->id
            );
        }

        return redirect(
            config('app.frontend_url') . '/payment/cancel?status=failed&reason=capture_failed'
        );
    }

    // ONE-TIME CANCEL
    public function oneTimeCancel(Request $request)
    {
        if ($request->token) {
            UserSubscription::where('paypal_order_id', $request->token)
                ->update(['status' => 'CANCELLED']);
        }

        return redirect(
            config('app.frontend_url') . '/payment/cancel?status=cancelled'
        );
    }
}
