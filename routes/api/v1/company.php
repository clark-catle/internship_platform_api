<?php

use App\Http\Controllers\V1\CompanyController;
use App\Http\Controllers\V1\InternshipController;
use Illuminate\Support\Facades\Route;

Route::middleware(['role:company'])->prefix('company')->group(function () {
  //Company info
  Route::post('/addCompany', [CompanyController::class, 'addCompany'])->name('addCompany');
  Route::put('/editCompany', [CompanyController::class, 'editCompany'])->name('editCompany');
  Route::get('/getCompany', [CompanyController::class, 'getCompany'])->name('getCompany');

  //Internship
  Route::get('/internship', [InternshipController::class, 'companyInternship'])->name('companyInternship');
  Route::get('/internship/{internship}', [InternshipController::class, 'specificCompanyInternship'])->name('specificCompanyInternship');
  Route::post('/addInternship', [InternshipController::class, 'addInternship'])->name('addInternship');
  Route::put('/editInternship/{internship}', [InternshipController::class, 'editInternship'])->name('editInternship');
  Route::delete('/deleteInternship/{internship}', [InternshipController::class, 'deleteInternship'])->name('deleteInternship');
  Route::put('/restoreInternship/{internship}', [InternshipController::class, 'restoreInternship'])->name('restoreInternship')->withTrashed();
});
