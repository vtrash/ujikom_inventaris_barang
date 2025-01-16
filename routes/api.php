<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangInventarisController;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\VendorBarangController;
use App\Models\BarangInventaris;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::group([
    'middleware' => 'auth:api',
], function () {
    Route::get('/user', [AuthController::class, 'me']);
    Route::get('/refresh', [AuthController::class, 'refresh']);
    Route::get('/logout', [AuthController::class, 'logout']);

    Route::group(['prefix' => 'jenis-barang'], function () {
        Route::get('/', [JenisBarangController::class, 'index']);
        Route::post('/', [JenisBarangController::class, 'store']);
        Route::put('/{jenisBarang}', [JenisBarangController::class, 'update']);
        Route::delete('/{jenisBarang}', [JenisBarangController::class, 'destroy']);
    });
    
    Route::group(['prefix' => 'vendor-barang'], function () {
        Route::get('/', [VendorBarangController::class, 'index']);
        Route::post('/', [VendorBarangController::class, 'store']);
        Route::put('/{vendorBarang}', [VendorBarangController::class, 'update']);
        Route::delete('/{vendorBarang}', [VendorBarangController::class, 'destroy']);
    });

    Route::group(['prefix' => 'barang-inventaris'], function () {
        Route::get('/', [BarangInventarisController::class, 'index']);
        Route::post('/', [BarangInventarisController::class, 'store']);
        Route::put('/{barangInventaris}', [BarangInventarisController::class, 'update']);
        Route::delete('/{barangInventaris}', [BarangInventarisController::class, 'destroy']);
    });

    Route::group(['prefix' => 'kelas'], function () {
        Route::get('/', [KelasController::class, 'index']);
        Route::post('/', [KelasController::class, 'store']);
        Route::put('/{kelas}', [KelasController::class, 'update']);
        Route::delete('/{kelas}', [KelasController::class, 'destroy']);
    });
});

Route::post('test', function() {
    $latestData = BarangInventaris::orderByDesc('kode_barang')->first();

    $isNewYear = date('Y') > date('Y', strtotime($latestData->tgl_entry));

    $startId = 1;

    if (!$isNewYear) {
        $startId = $latestData ? (int) substr($latestData['kode_jenis_barang'], 2) + 1 : 1;
    }
    
    return 'INV' . date('Y') . str_pad($startId, 5, 0, STR_PAD_LEFT);
});