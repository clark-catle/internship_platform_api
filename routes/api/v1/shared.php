<?php

use App\Http\Controllers\V1\FileController;
use App\Http\Controllers\V1\InternshipController;
use Illuminate\Support\Facades\Route;

Route::middleware('role.not:company')->group(function () {
  // File
  Route::prefix('file')->group(function () {
    Route::get('/company/{company}/logo', [FileController::class, 'getCompanyLogo'])->name('logo_company');
  });

  // Internship
  Route::prefix('internship')->group(function () {
    Route::get('/viewInternship', [InternshipController::class, 'viewInternship'])->name('viewInternship');
    Route::get('/viewInternship/{internship}', [InternshipController::class, 'viewSpecificInternship'])->name('viewSpecificInternship');
  });
});
