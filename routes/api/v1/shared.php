<?php

use App\Http\Controllers\V1\FileController;
use Illuminate\Support\Facades\Route;

// File endpoints
Route::prefix('file')->group(function () {
  Route::get('/company/{company}/logo', [FileController::class, 'getCompanyLogo'])->name('logo_company');
});
