<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CapacityController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerDetailsController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VenueController;
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
})->name('homepage');

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
    Route::get('/order_form', 'old_order_form');
    Route::get('/order_form/{venue_id}', 'order_form')->name('order_form');
    Route::post('/submit_venue', 'submit_venue')->name('submit_venue');
    Route::get('/customer_details', 'customer_details')->name(
        'customer_details'
    );
    Route::get('/submit_details', 'submit_details')->name('submit_details');
    Route::get('/payment_details/{order_id}', 'payment_details')->name(
        'payment_details'
    );
    Route::put('/update_order/{order_id}', 'update_order')->name(
        'update_order'
    );
    Route::get('/edit_order/{order_id}', 'edit_order')->name('edit_order');
    Route::post('/update_customer/{order_id}', 'update_customer')->name(
        'update_customer'
    );
});

/** venue */
Route::controller(VenueController::class)
    ->as('venue.')
    ->prefix('venue')
    ->group(function () {
        Route::get('/all', 'view')->name('view');
    });

/** payment */
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
        Route::get('/order/{order_id}', 'email_receipt')->name('email_receipt');
        Route::get('/success', 'success')->name('success');
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
            Route::get('/update/{id}', 'update')->name('update');
            Route::get('/create', 'create')->name('create');
            Route::post('/submit', 'submit')->name('submit');
            Route::put('/update/{id}', 'update_venue')->name('update_venue');
        });
});

Route::middleware('auth')->group(function () {
    Route::controller(OrderController::class)
        ->as('orders.')
        ->prefix('orders')
        ->middleware('auth:web')
        ->group(function () {
            Route::get('/view', 'view')->name('view');
            Route::get('/view/{order_id}', 'view_order')->name('view_order');
        });
});

Route::middleware('auth')->group(function () {
    Route::controller(CustomerDetailsController::class)
        ->as('customers.')
        ->prefix('customers')
        ->middleware('auth:web')
        ->group(function () {
            Route::get('/view', 'view')->name('view');
            Route::get('/view/{order_id}', 'view_order')->name('view_order');
        });
});

Route::middleware('auth')->group(function () {
    Route::controller(CapacityController::class)
        ->as('capacity.')
        ->prefix('capacity')
        ->middleware('auth:web')
        ->group(function () {
            Route::get('/view/{venue_id}', 'view_venue_capacity')->name(
                'view_venue_capacity'
            );
            // Route::get('/view/{id}', 'view')->name('view');
            Route::get('/update/{id}', 'update')->name('update');
            Route::put('/update/{id}', 'update_capacity')->name(
                'update_capacity'
            );
            Route::get('/create', 'create')->name('create');
            Route::post('/submit', 'submit')->name('submit');
            Route::get('/download_excel/{id}', 'download_excel')->name(
                'download_excel'
            );
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