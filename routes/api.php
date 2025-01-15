<?php

use App\Helpers\GenerateID;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JenisBarangController;
use App\Models\JenisBarang;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::group([
    'middleware' => 'auth:api',
], function () {
    Route::get('/user', [AuthController::class, 'me'])->middleware('auth:api');
    Route::get('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
    Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth:api');

    Route::group(['prefix' => 'jenis-barang'], function () {
        Route::get('/', [JenisBarangController::class, 'index']);
        Route::post('/', [JenisBarangController::class, 'store']);
        Route::put('/{jenisBarang}', [JenisBarangController::class, 'update']);
        Route::delete('/{jenisBarang}', [JenisBarangController::class, 'destroy']);
    });
});

Route::post('test', fn() => GenerateID::generateId(JenisBarang::class, 'JB', 5, 'kode_jenis_barang'));