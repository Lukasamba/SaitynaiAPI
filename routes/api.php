<?php

use App\Http\Controllers\DivisionController;
use App\Http\Controllers\HallController;
use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth.jwt']], function () {
    Route::group(['prefix' => 'divisions'], function() {
        Route::get('', [DivisionController::class, 'getList']);

        Route::post('', [DivisionController::class, 'createDivision']);
        Route::get('{division}', [DivisionController::class, 'getDivision']);
        Route::put('{division}', [DivisionController::class, 'updateDivision']);
        Route::delete('{division}', [DivisionController::class, 'deleteDivision']);
    });

    Route::group(['prefix' => 'halls'], function() {
        Route::get('', [HallController::class, 'getList']);

        Route::post('', [HallController::class, 'createHall']);
        Route::get('{hall}', [HallController::class, 'getHall']);
        Route::put('{hall}', [HallController::class, 'updateHall']);
        Route::delete('{hall}', [HallController::class, 'deleteHall']);
    });

    Route::group(['prefix' => 'movies'], function() {
        Route::get('', [MovieController::class, 'getList']);

        Route::post('', [MovieController::class, 'createMovie']);
        Route::get('{movie}', [MovieController::class, 'getMovie']);
        Route::put('{movie}', [MovieController::class, 'updateMovie']);
        Route::delete('{movie}', [MovieController::class, 'deleteMovie']);
    });
});
