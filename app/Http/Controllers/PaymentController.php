<?php

namespace App\Http\Controllers;

use App\Models\Capacity;
use App\Models\CustomerDetails;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Session;
use Stripe;

class PaymentController extends Controller
{
    public function submit_payment($order_id)
    {
        $order = Order::find($order_id);
        // Set your secret key. Remember to switch to your live secret key in production.
        // See your keys here: https://dashboard.stripe.com/apikeys

        //\Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        \Stripe\Stripe::setApiKey(
            'sk_test_51MgKcIJLVz02y2VzJ9UTdBxzPCB4nTEf94hhqZazHgFMvPhmSW6QfLycns7MTAxHh48dLXh3hyTx8U0rQxtDojzh00ZQUVrVtq'
        );

        $intent = \Stripe\PaymentIntent::create([
            'amount' => number_format((float) $order->total, 2, '.', '') * 100,
            'currency' => 'myr',
            'payment_method_types' => ['fpx'],
            'receipt_email' => $order->customer_email,
            'metadata' => [
                'order_id' => $order->id,
                'customer' => $order->customer_name,
            ],
        ]);

        return view('submit_payment', [
            'order_id' => $order_id,
            'intent' => $intent,
        ]);
    }

    public function confirm_payment(Request $request)
    {
        //$stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $stripe = new \Stripe\StripeClient(
            'sk_test_51MgKcIJLVz02y2VzJ9UTdBxzPCB4nTEf94hhqZazHgFMvPhmSW6QfLycns7MTAxHh48dLXh3hyTx8U0rQxtDojzh00ZQUVrVtq'
        );
        $request->session()->flush();
        $all = $request->except('_token', '_method');
        $status = $all['redirect_status'];
        $total_customers = 0;

        $data = $stripe->paymentIntents->retrieve($all['payment_intent']);
        $fpx_id = "";
        $fpx_id = $data['id'];
        $order_id = $data['metadata']['order_id'];

        $order = Order::find($order_id);
        $order->fpx_id = $fpx_id;

        if ($status == 'succeeded') {
            $capacity = Capacity::find($order->capacity_id);

            foreach ($order->order_details as $item) {
                $total_customers += $item->quantity;
            }

            //dd($total_customers);

            $current_capacity = $capacity->max_capacity - $total_customers;
            $capacity->current_capacity = $current_capacity;
            $capacity->save();

            $order->status = 'Paid';
            $order->updated_at = Carbon::now();
            $order->save();

            return redirect()->route('mail.email_receipt', [
                'order_id' => $order_id,
            ]);
        } else {
            $order->fpx_id = $fpx_id;
            $order->status = 'Failed';
            $order->updated_at = Carbon::now();
            $order->save();

            return view('payment.failed');
        }
    }
}