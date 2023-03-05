<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function view_login_page()
    {
        if (auth()->check()) {
            if (auth()->user()->role == 1) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('customer.dashboard');
            }
        } else {
            return view('auth.login');
        }
    }

    public function view_register_page()
    {
        if (auth()->check()) {
            if (auth()->user()->role == 1) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('customer.dashboard');
            }
        } else {
            return view('auth.register');
        }
    }

    public function register(Request $request)
    {
        $validated = request()->validate([
            'name' => ['string', 'required'],
            'email' => ['email', 'required', 'unique:users,email'],
            'password' => ['string', 'required'],
        ]);

        if ($validated) {
            User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'role' => 2,
            ]);

            return redirect()->route('mail.verify_email', [
                'email' => $request['email'],
                'name' => $request['name'],
            ]);
        } else {
            return redirect()
                ->route('auth.register')
                ->withErrors([
                    'fail',
                    'Your email/password is invalid. Try again.',
                ]);
        }
    }

    public function validate_login(Request $request)
    {
        $validated = request()->validate([
            'email' => ['email', 'required'],
            'password' => ['string', 'required'],
        ]);

        if (auth()->check()) {
            if (auth()->user()->role == 1) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('customer.dashboard');
            }
        } else {
            if ($validated && Auth::attempt($validated)) {
                $get_user_role = User::where(
                    'email',
                    $request['email']
                )->first();
                $get_user_role = $get_user_role->role;
                if ($get_user_role == 1) {
                    return redirect()->route('admin.dashboard');
                } else {
                    return redirect()->route('customer.dashboard');
                }
            } else {
                return redirect()
                    ->route('auth.login')
                    ->with('fail', 'Incorrect email or password.');
            }
        }
    }

    // public function forgot_password()
    // {
    // }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();

        return redirect()->route('auth.login');
    }
}