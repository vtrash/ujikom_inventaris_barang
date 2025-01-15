<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::group([
    'middleware' => 'auth:api',
], function () {
    Route::get('/user', [AuthController::class, 'me'])->middleware('auth:api');
    Route::get('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
    Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
});