<?php

use App\Http\Controllers\V1\AdminCreationController;
use App\Http\Controllers\V1\CompanyController;
use App\Http\Controllers\V1\InternshipController;
use App\Http\Controllers\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['role:admin'])->group(function () {
  Route::patch('/user/{user}/changeStatus', [UserController::class, 'userChangeStatus'])->name('userChangeStatus');

  Route::patch('/company/{company}/verify', [CompanyController::class, 'changeVerification'])->name('changeVerification');

  Route::delete('/internship/{internship}/forceRemove', [InternshipController::class, 'forceRemove'])->name('forceRemove');

  Route::prefix('createAdmin')->group(function () {
    Route::get('/', [AdminCreationController::class, 'viewTokens'])->name('viewTokens');
    Route::post('/', [AdminCreationController::class, 'createToken'])->name('createToken');
    Route::post('/register', [AdminCreationController::class, 'registerAdmin'])->name('registerAdmin');
  });
});
