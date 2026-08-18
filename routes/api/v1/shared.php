<?php

use App\Http\Controllers\V1\ApplicationController;
use App\Http\Controllers\V1\CompanyController;
use App\Http\Controllers\V1\FileController;
use App\Http\Controllers\V1\InternshipController;
use App\Http\Controllers\V1\PasswordController;
use Illuminate\Support\Facades\Route;

Route::middleware('role.not:company')->group(function () {
  // View logo of the company
  Route::get('/company', [CompanyController::class, 'viewCompany'])->name('viewCompany');
  Route::get('/company/{company}', [CompanyController::class, 'viewSpecificCompany'])->name('viewSpecificCompany');
  Route::get('/company/{company}/logo', [CompanyController::class, 'getCompanyLogo'])->name('getCompanyLogo');

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
});
