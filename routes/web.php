<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CapacityController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::controller(LoginController::class)
    ->as('auth.')
    ->group(function () {
        Route::get('/register', 'view_register_page')->name('register');
        Route::post('/register', 'register')->name('signup');
        Route::get('/login', 'view_login_page')->name('login');
        Route::post('/validate', 'validate_login')->name('validate');
        Route::get('/logout', 'logout')
            ->name('logout')
            ->middleware(['auth']);
    });

/** customer order */
Route::controller(OrderController::class)->group(function () {
    Route::get('/order_form', 'order_form')->name('order_form');
    Route::post('/submit_venue', 'submit_venue')->name('submit_venue');
    Route::get('/customer_details', 'customer_details')->name(
        'customer_details'
    );
    Route::post('/submit_details', 'submit_details')->name('submit_details');
    Route::get('/payment_details/{order_id}', 'payment_details')->name(
        'payment_details'
    );
    Route::get('/edit_order/{order_id}', 'edit_order')->name('edit_order');
    Route::post('/update_customer/{order_id}', 'update_customer')->name(
        'update_customer'
    );
});

Route::controller(PaymentController::class)->group(function () {
    Route::get('/submit_payment/{order_id}', 'submit_payment')->name(
        'submit_payment'
    );
    Route::get('/successful', 'confirm_payment')->name('confirm_payment');
});

Route::controller(MailController::class)
    ->as('mail.')
    ->prefix('mail')
    ->group(function () {
        Route::get('/verify/{email}/{name}', 'verify_email')->name(
            'verify_email'
        );
        Route::get('/confirm/{email}', 'email_verified')->name('confirm');
        Route::get('/order/{order_id}', 'email_receipt')->name(
            'email_receipt'
        );
    });

Route::middleware('auth')->group(function () {
    Route::controller(AdminController::class)
        ->as('admin.')
        ->prefix('admin')
        ->middleware('auth:web')
        ->group(function () {
            Route::get('/dashboard', 'index')->name('dashboard');
        });
});

Route::middleware('auth')->group(function () {
    Route::controller(CustomerController::class)
        ->as('customer.')
        ->prefix('customer')
        ->middleware('auth:web')
        ->group(function () {
            Route::get('/dashboard', 'index')->name('dashboard');
        });
});

Route::middleware('auth')->group(function () {
    Route::controller(ProductController::class)
        ->as('product.')
        ->prefix('product')
        ->middleware('auth:web')
        ->group(function () {
            Route::get('/view', 'view')->name('view');
            Route::get('/update', 'update')->name('update');
            Route::get('/create', 'create')->name('create');
            Route::post('/submit', 'submit')->name('submit');
        });
});

Route::middleware('auth')->group(function () {
    Route::controller(CapacityController::class)
        ->as('capacity.')
        ->prefix('capacity')
        ->middleware('auth:web')
        ->group(function () {
            Route::get('/view/{venueId}', 'view_venue_capacity')->name(
                'view_venue_capacity'
            );
            Route::get('/view', 'view')->name('view');
            Route::get('/update', 'update')->name('update');
            Route::get('/create', 'create')->name('create');
            Route::post('/submit', 'submit')->name('submit');
        });
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});