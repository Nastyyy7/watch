<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderProductController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::apiResource('products', ProductController::class);
    Route::apiResource('types', TypeController::class);
    Route::apiResource('statuses', StatusController::class);
    Route::apiResource('reviews', ReviewController::class);
    Route::apiResource('orders', OrderController::class);
    Route::apiResource('order_product', OrderProductController::class);
    Route::apiResource('order_status', OrderStatusController::class);
    Route::apiResource('users', UserController::class);

    Route::post('/register', [RegisteredUserController::class, 'store'])
        ->middleware('guest')
        ->name('register');

    // Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    //     ->middleware('guest')
    //     ->name('login');

    // Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    //     ->middleware('guest')
    //     ->name('password.email');

    // Route::post('/reset-password', [NewPasswordController::class, 'store'])
    //     ->middleware('guest')
    //     ->name('password.store');

    Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['auth', 'signed', 'throttle:6,1'])
        ->name('verification.verify');

    // Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    //     ->middleware(['auth', 'throttle:6,1'])
    //     ->name('verification.send');

    // Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    //     ->middleware('auth')
    //     ->name('logout');
});
