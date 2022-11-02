<?php

use App\Http\Controllers\AuthenticationController;

Route::post('register', [AuthenticationController::class, 'register']);
Route::post('login', [AuthenticationController::class, 'login']);

Route::group(['middleware' => ['auth.jwt']], function () {
    Route::post('logout', [AuthenticationController::class, 'logout']);
});
