<?php

namespace App\Http\Controllers;

use App\Mail\VerifyRegister;
use App\Models\User;
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
}