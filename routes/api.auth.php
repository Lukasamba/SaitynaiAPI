<?php

use App\Http\Controllers\AuthenticationController;

Route::post('register', [AuthenticationController::class, 'register'])->middleware('api');
Route::post('login', [AuthenticationController::class, 'login'])->middleware('api');
Route::post('logout', [AuthenticationController::class, 'logout'])->middleware('api');
