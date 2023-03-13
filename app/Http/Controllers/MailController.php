<?php

namespace App\Http\Controllers;

use App\Mail\EmailReceipt;
use App\Mail\VerifyRegister;
use App\Models\Capacity;
use App\Models\Order;
use App\Models\User;
use App\Models\Venue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function verify_email($email, $name)
    {
        $mailData = [
            'title' => 'Welcome to Cahya Mata Catering (CMC)',
            'name' => $name,
            'email' => $email,
        ];

        Mail::to($email)->send(new VerifyRegister($mailData));
    }

    public function email_verified($email)
    {
        $user = User::where('email', $email)->first();
        $user->email_verified_at = Carbon::now();
        $user->save();
        return redirect()
            ->route('auth.login')
            ->with(
                'success',
                'Your email has been verified. Login to view your order.'
            );
    }

    public function email_receipt($order_id)
    {
        $order = Order::find($order_id);
        $capacity = Capacity::find($order->capacity_id);
        $venue_id = $capacity->venue_id;
        $venue = Venue::find($venue_id);
        $venue = $venue->venue_name . ', ' . $venue->venue_location;
        $venue_date = date('d-m-Y l', strtotime($order->date_chosen));

        $mailData = [
            'order' => $order,
            'venue' => $venue,
            'venue_date' => $venue_date,
        ];

        $emails = [$order->customer_email, 'admin@cahyamatacatering.com'];
        //dd($mailData['order']['subtotal']);
        Mail::to($emails)->send(new EmailReceipt($mailData));

        return redirect()->route('mail.success');
    }

    public function success()
    {
        return view('payment.confirm');
    }
}