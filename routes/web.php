<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MailController;
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
        // Route::get('/logout', 'logout')
        //     ->name('logout')
        //     ->middleware(['auth']);
    });

Route::get('/tempah-sekarang', function () {
    return view('orders.index');
});

Route::controller(MailController::class)
    ->as('mail.')
    ->prefix('mail')
    ->group(function () {
        Route::get('/verify/{email}/{name}', 'verify_email')->name(
            'verify_email'
        );
        Route::get('/confirm/{email}', 'email_verified')->name('confirm');
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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});