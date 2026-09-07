<?php

use App\Http\Controllers\V1\ApplicationController;
use App\Http\Controllers\V1\CompanyController;
use App\Http\Controllers\V1\InternshipController;
use App\Http\Controllers\V1\NotificationController;
use App\Http\Controllers\V1\PasswordController;
use Illuminate\Support\Facades\Route;

Route::middleware('role.not:company')->group(function () {
  // Company
  Route::prefix('company')->group(function () {
    Route::get('/', [CompanyController::class, 'viewCompany'])->name('viewCompany');
    Route::get('/{company}', [CompanyController::class, 'viewSpecificCompany'])->name('viewSpecificCompany');
    Route::get('/{company}/logo', [CompanyController::class, 'getCompanyLogo'])->name('getCompanyLogo');
  });

  // Internship
  Route::prefix('internship')->group(function () {
    Route::get('/', [InternshipController::class, 'viewInternship'])->name('viewInternship');
    Route::get('/{internship}', [InternshipController::class, 'viewSpecificInternship'])->name('viewSpecificInternship');
  });
});

// Application of internship
Route::prefix('application')->group(function () {
  Route::get('/', [ApplicationController::class, 'viewAllApplication'])->name('viewAllApplication');
  Route::get('/{application}', [ApplicationController::class, 'viewApplication'])->name('viewApplication');
  Route::get('/{application}/resume', [ApplicationController::class, 'viewApplicationResume'])->name('viewApplicationResume');
});

// User
Route::prefix('user')->group(function () {
  Route::post('/forgotPassword', [PasswordController::class, 'sendForgotPassword'])->name('sendForgotPassword');
  Route::patch('/resetPassword', [PasswordController::class, 'resetPassword'])->name('resetPassword');
  Route::patch('/changePassword', [PasswordController::class, 'changePassword'])->name('changePassword');

  // notification
  Route::prefix('notification')->group(function () {
    Route::get('/', [NotificationController::class, 'getAllNotification'])->name('getAllNotification');
    Route::get('/unreadCount', [NotificationController::class, 'unreadCount'])->name('unreadCount');
    Route::patch('/{notification}/read', [NotificationController::class, 'markAsRead'])->name('markAsRead');
    Route::patch('/markAllRead', [NotificationController::class, 'markAllRead'])->name('markAllRead');
    Route::delete('/{notification}', [NotificationController::class, 'deleteNotif'])->name('deleteNotif');
  });
});
