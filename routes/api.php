<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangInventarisController;
use App\Http\Controllers\BatchBarangController;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\VendorBarangController;
use App\Models\Pengembalian;
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

    Route::group(['prefix' => 'batch-barang'], function () {
        Route::get('/', [BatchBarangController::class, 'index']);
        Route::post('/', [BatchBarangController::class, 'store']);
        Route::put('/{batchBarang}', [BatchBarangController::class, 'update']);
        Route::delete('/{batchBarang}', [BatchBarangController::class, 'destroy']);
    });

    Route::group(['prefix' => 'barang-inventaris'], function () {
        Route::get('/', [BarangInventarisController::class, 'index']);
        Route::get('/{barangInventaris}', [BarangInventarisController::class, 'show']);
        Route::post('/', [BarangInventarisController::class, 'store']);
        Route::put('/{barangInventaris}', [BarangInventarisController::class, 'update']);
        Route::delete('/{barangInventaris}', [BarangInventarisController::class, 'destroy']);
    });
    
    Route::group(['prefix' => 'jurusan'], function () {
        Route::get('/', [JurusanController::class, 'index']);
        Route::post('/', [JurusanController::class, 'store']);
        Route::put('/{jurusan}', [JurusanController::class, 'update']);
        Route::delete('/{jurusan}', [JurusanController::class, 'destroy']);
    });
    
    Route::group(['prefix' => 'kelas'], function () {
        Route::get('/', [KelasController::class, 'index']);
        Route::post('/', [KelasController::class, 'store']);
        Route::put('/{kelas}', [KelasController::class, 'update']);
        Route::delete('/{kelas}', [KelasController::class, 'destroy']);
    });
    
    Route::group(['prefix' => 'siswa'], function () {
        Route::get('/', [SiswaController::class, 'index']);
        Route::get('/{siswa}', [SiswaController::class, 'show']);
        Route::post('/', [SiswaController::class, 'store']);
        Route::put('/{siswa}', [SiswaController::class, 'update']);
        Route::delete('/{siswa}', [SiswaController::class, 'destroy']);
    });
    
    Route::group(['prefix' => 'peminjaman'], function () {
        Route::get('/', [PeminjamanController::class, 'index']);
        Route::get('/{peminjaman}', [PeminjamanController::class, 'show']);
        Route::post('/', [PeminjamanController::class, 'store']);
        // Route::put('/{siswa}', [PeminjamanController::class, 'update']);
        // Route::delete('/{siswa}', [PeminjamanController::class, 'destroy']);
    });

    Route::group(['prefix' => 'pengembalian'], function () {
        Route::put('/{pengembalian}', [PengembalianController::class, 'update']);
    });
});

Route::post('test', function () {
    $data = Pengembalian::generateId(10);

    return $data;
});