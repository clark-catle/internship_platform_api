<?php

use App\Http\Controllers\V1\CompanyController;
use App\Http\Controllers\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['role:admin'])->group(function () {
  Route::patch('/user/{user}/changeStatus', [UserController::class, 'userChangeStatus'])->name('userChangeStatus');

  Route::patch('/company/{company}/verify', [CompanyController::class, 'changeVerification'])->name('changeVerification');
});
