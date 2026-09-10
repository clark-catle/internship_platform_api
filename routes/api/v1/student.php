<?php

use App\Http\Controllers\V1\ApplicationController;
use App\Http\Controllers\V1\StudentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['role:student'])->prefix('student')->group(function () {
  Route::post('/addStudent', [StudentController::class, 'addStudent'])->name('addStudent');
  Route::put('/editStudent', [StudentController::class, 'editStudent'])->name('editStudent');
  Route::get('/getStudent', [StudentController::class, 'getStudent'])->name('getStudent');
  Route::get('/resume', [StudentController::class, 'viewResume'])->name('viewResume');

  //apply
  Route::post('/internship/{internship}/apply', [ApplicationController::class, 'applyInternship'])->name('applyInternship');
});
