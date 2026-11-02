<?php

namespace App\Http\Controllers\API\Paypal;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class DonationController extends Controller
{
    use ApiResponse;

    public function paypalDonate(Request $request)
    {

        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        // Save donation in database
        $donation = Donation::create([
            'user_id'           => auth()->id(),
            'amount'            => $request->amount,
            'currency'          => 'USD',
            'status'            => 'PENDING',
        ]);

        // Paypal..
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $data = [
            "intent" => "CAPTURE",
            "application_context" => [
                'return_url' => config('app.url') . '/api/paypal-donate/success',
                'cancel_url' => config('app.url') . '/api/paypal-donate/cancel',
            ],
            "purchase_units" => [
                [
                    "reference_id" => $donation->id,
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => number_format($request->amount, 2, '.', ''),
                    ]
                ]
            ]
        ];

        // Create Order
        $order  = $provider->createOrder($data);

        $donation->update([
            'paypal_order_id' => $order['id']
        ]);

        $url    = collect($order['links'])->where('rel', 'approve')->first()['href'];
        $data   = [
            'order_id'      => $order['id'],
            'approve_url'   => $url,
        ];

        return $this->success('Order Created!', $data, 200);
    }


    public function paypalDonateSuccess(Request $request)
    {

        $request->validate([
            'token' => 'required|string'
        ]);

        $token = $request->token;

        $donation = Donation::where('paypal_order_id', $token)
            ->where('status', 'PENDING')
            ->firstOrFail();

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        // ✅ Check order approved or not
        $orderDetails = $provider->showOrderDetails($token);

        if ($orderDetails['status'] !== 'APPROVED') {

            return $this->error('Order not approved by payer', 400);
        }

        // ✅ Capture payment
        $order = $provider->capturePaymentOrder($token);

        if ($order['status'] === 'COMPLETED') {
            $capture = $order['purchase_units'][0]['payments']['captures'][0];

            $donation->update([
                'paypal_capture_id' => $capture['id'],
                'status' => 'COMPLETED',
            ]);

            return redirect(
                config('app.frontend_url') . '/payment/success'
            );
        }

        $donation->update(['status' => 'FAILED']);

        return redirect(
            config('app.frontend_url') . '/subscription/cancel'
        );
    }


    public function paypalDonateCancel(Request $request)
    {
        if ($request->has('token')) {
            Donation::where('paypal_order_id', $request->token)
                ->update(['status' => 'CANCELLED']);
        }

        return redirect(
            config('app.frontend_url') . '/subscription/cancel'
        );
    }

}
