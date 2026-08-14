<?php

use App\Http\Controllers\V1\ApplicationController;
use App\Http\Controllers\V1\CompanyController;
use App\Http\Controllers\V1\InternshipController;
use Illuminate\Support\Facades\Route;

Route::middleware(['role:company'])->prefix('company')->group(function () {
  //Company info
  Route::post('/addCompany', [CompanyController::class, 'addCompany'])->name('addCompany');
  Route::put('/editCompany', [CompanyController::class, 'editCompany'])->name('editCompany');
  Route::get('/getCompany', [CompanyController::class, 'getCompany'])->name('getCompany');
  Route::get('/getLogo', [CompanyController::class, 'getLogo'])->name('getLogo');

  //Internship
  Route::prefix('internship')->group(function () {
    Route::get('/', [InternshipController::class, 'companyInternship'])->name('companyInternship');
    Route::get('/{internship}', [InternshipController::class, 'specificCompanyInternship'])->name('specificCompanyInternship');
    Route::get('/{internship}/application', [InternshipController::class, 'viewApplicationsOfInternship'])->name('viewApplicationsOfInternship');
    Route::post('/addInternship', [InternshipController::class, 'addInternship'])->name('addInternship');
    Route::put('/{internship}/editInternship', [InternshipController::class, 'editInternship'])->name('editInternship');
    Route::delete('/{internship}/deleteInternship', [InternshipController::class, 'deleteInternship'])->name('deleteInternship');
    Route::put('/{internship}/restoreInternship', [InternshipController::class, 'restoreInternship'])->name('restoreInternship')->withTrashed();
  });

  //Application
  Route::prefix('application')->group(function () {
    Route::put('{application}/interview', [ApplicationController::class, 'interviewApplication'])->name('interviewApplication');
    Route::put('{application}/decide', [ApplicationController::class, 'decideApplication'])->name('decideApplication');
    Route::put('{application}/accept', [ApplicationController::class, 'acceptApplication'])->name('acceptApplication');
    Route::put('{application}/reject', [ApplicationController::class, 'rejectApplication'])->name('rejectApplication');
    Route::put('{application}/revertReject', [ApplicationController::class, 'revertRejectApplication'])->name('revertRejectApplication');
  });
});
