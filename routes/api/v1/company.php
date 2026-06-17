<?php

use App\Http\Controllers\V1\CompanyController;
use Illuminate\Support\Facades\Route;

Route::middleware(['role:company'])->prefix('company')->group(function () {
  Route::post('/addCompany', [CompanyController::class, 'addCompany'])->name('addCompany');
  Route::put('/editCompany', [CompanyController::class, 'editCompany'])->name('editCompany');
});
