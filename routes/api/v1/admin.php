<?php

use App\Http\Controllers\V1\AdminCreationController;
use App\Http\Controllers\V1\CompanyController;
use App\Http\Controllers\V1\InternshipController;
use App\Http\Controllers\V1\StudentController;
use App\Http\Controllers\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['role:admin'])->group(function () {
  Route::prefix('user')->group(function () {
    Route::patch('/', [UserController::class, 'viewAllUser'])->name('viewAllUser');
    Route::patch('/{user}/changeStatus', [UserController::class, 'userChangeStatus'])->name('userChangeStatus');
  });

  Route::patch('/company/{company}/verify', [CompanyController::class, 'changeVerification'])->name('changeVerification');

  Route::get('/student', [StudentController::class, 'viewAllStudent'])->name('viewAllStudent');;

  Route::delete('/internship/{internship}/forceRemove', [InternshipController::class, 'forceRemove'])->name('forceRemove');

  Route::prefix('createAdmin')->group(function () {
    Route::get('/', [AdminCreationController::class, 'viewTokens'])->name('viewTokens');
    Route::post('/', [AdminCreationController::class, 'createToken'])->name('createToken');
    Route::post('/register', [AdminCreationController::class, 'registerAdmin'])->name('registerAdmin');
    Route::delete('/{adminCreation}', [AdminCreationController::class, 'deleteToken'])->name('deleteToken');
  });
});
