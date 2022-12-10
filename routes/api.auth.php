<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\MovieController;

Route::post('register', [AuthenticationController::class, 'register']);
Route::post('login', [AuthenticationController::class, 'login']);

Route::group(['middleware' => ['auth.jwt']], function () {
    Route::post('logout', [AuthenticationController::class, 'logout']);
    Route::put('refresh', [AuthenticationController::class, 'refresh']);
});

Route::group(['prefix' => 'movies'], function() {
    Route::get('', [MovieController::class, 'getList']);
});
