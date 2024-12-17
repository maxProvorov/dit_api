<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\StockController;

Route::get('/cities', [CityController::class, 'index']);
Route::get('/city/{id}', [CityController::class, 'show']);
Route::get('/city/{id}/stocks', [StockController::class, 'stocksByCity']);
Route::get('/stocks', [StockController::class, 'index']);
Route::get('/stocks/{id}', [StockController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/city', [CityController::class, 'store']);
    Route::put('/city/{id}', [CityController::class, 'update']);
    Route::delete('/city/{id}', [CityController::class, 'destroy']);

    Route::post('/stocks', [StockController::class, 'store']);
    Route::put('/stock/{id}', [StockController::class, 'update']);
    Route::delete('/stock/{id}', [StockController::class, 'destroy']);

    Route::post('/stock/nearby', [StockController::class, 'nearestStock']);
});