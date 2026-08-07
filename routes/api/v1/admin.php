<?php

use App\Http\Controllers\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['role:admin'])->group(function () {
  Route::get('/user/{user}/changeStatus', [UserController::class, 'userChangeStatus'])->name('userChangeStatus');
});
