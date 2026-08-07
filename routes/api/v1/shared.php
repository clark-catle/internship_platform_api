<?php

use App\Http\Controllers\V1\ApplicationController;
use App\Http\Controllers\V1\CompanyController;
use App\Http\Controllers\V1\FileController;
use App\Http\Controllers\V1\InternshipController;
use Illuminate\Support\Facades\Route;

Route::middleware('role.not:company')->group(function () {
  // View logo of the company
  Route::get('/company', [CompanyController::class, 'viewCompany'])->name('viewCompany');
  Route::get('/company/{company}', [CompanyController::class, 'viewSpecificCompany'])->name('viewSpecificCompany');
  Route::get('/company/{company}/logo', [CompanyController::class, 'getCompanyLogo'])->name('getCompanyLogo');

  // Internship
  Route::prefix('internship')->group(function () {
    Route::get('/viewInternship', [InternshipController::class, 'viewInternship'])->name('viewInternship');
    Route::get('/viewInternship/{internship}', [InternshipController::class, 'viewSpecificInternship'])->name('viewSpecificInternship');
  });
});

// Application of internship
Route::prefix('application')->group(function () {
  Route::get('{application}', [ApplicationController::class, 'viewApplication'])->name('viewApplication');
  Route::get('{application}/resume', [ApplicationController::class, 'viewApplicationResume'])->name('viewApplicationResume');
});
