<?php

use App\Http\Controllers\V1\AdminCreationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\PasswordController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::middleware(['throttle:public'])->group(function () {

        Route::post('/login', [AuthController::class, 'login'])->name('login');
        Route::post('/register', [AuthController::class, 'register'])->name('register');

        Route::post('/registerAdmin', [AdminCreationController::class, 'registerAdmin'])->name('registerAdmin');

        Route::post('/forgotPassword', [PasswordController::class, 'sendForgotPassword'])->name('sendForgotPassword');
        Route::patch('/resetPassword', [PasswordController::class, 'resetPassword'])->name('resetPassword');
    });

    Route::middleware(['auth:sanctum', 'status', 'verified', 'throttle:api'])->group(function () {
        require __DIR__ . '/api/v1/admin.php';
        require __DIR__ . '/api/v1/company.php';
        require __DIR__ . '/api/v1/student.php';
        require __DIR__ . '/api/v1/shared.php';
    });
});
