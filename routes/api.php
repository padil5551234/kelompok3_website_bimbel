<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\FormasiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('pembelian/midtrans-notification', [PembelianController::class, 'callback'])->name('midtrans_notification');

// Wilayah API (Existing)
Route::get('/province/{id}', [WilayahController::class, 'getProvince']);
Route::get('/regency/{id}', [WilayahController::class, 'getRegency']);
Route::get('/district/{id}', [WilayahController::class, 'getDistrict']);
Route::get('/search', [WilayahController::class, 'search']);
Route::get('/provinces', [WilayahController::class, 'getProvinces']);
Route::get('/regencies/{provinceId}', [WilayahController::class, 'getRegencies']);
Route::get('/districts/{regencyId}', [WilayahController::class, 'getDistricts']);

// New Wilayah API (Profile Integration)
use App\Http\Controllers\Api\WilayahController as ApiWilayahController;
Route::get('/wilayah/provinsi', [ApiWilayahController::class, 'getProvinsi']);
Route::get('/wilayah/kabupaten', [ApiWilayahController::class, 'getKabupaten']);
Route::get('/wilayah/kabupaten-by-kode', [ApiWilayahController::class, 'getKabupatenByKode']);
Route::get('/wilayah/search-kabupaten', [ApiWilayahController::class, 'searchKabupaten']);

// Formasi
Route::get('/prodi', [FormasiController::class, 'getAllProdi']);
Route::get('/prodi/{kode}', [FormasiController::class, 'getProdi']);
Route::get('/formasi', [FormasiController::class, 'getAllFormasi']);
Route::get('/formasi/{kode}', [FormasiController::class, 'getFormasi']);
