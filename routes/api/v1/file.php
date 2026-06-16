<?php

use App\Http\Controllers\V1\FileController;
use Illuminate\Support\Facades\Route;

Route::prefix('file')->group(function () {
  Route::get('/logo/{company}', [FileController::class, 'getCompanyLogo'])->name('logo_company');
});
