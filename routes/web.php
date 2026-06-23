<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\PengirimanController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\KurirController;
use App\Http\Controllers\TarifController;
use App\Http\Controllers\LaporanController;
use App\Models\User;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\LacakController;
use App\Http\Controllers\CekOngkirController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TransitController;

/*
|--------------------------------------------------------------------------
| RUTE PUBLIK (TIDAK BUTUH LOGIN)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);

// Rute Register Publik
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

Route::middleware(['auth'])->group(function () {
    Route::get('/paket-saya', [LacakController::class, 'paketSaya']);
});

// Rute Lacak Resi Publik
Route::get('/lacak', [LacakController::class, 'index']);
Route::post('/lacak', [LacakController::class, 'search']);

// Rute Cek Ongkir Publik
Route::get('/cek-ongkir', [CekOngkirController::class, 'index']); // Buka halaman
Route::post('/cek-ongkir', [CekOngkirController::class, 'hitung']);

// Rute Beranda (Landing Page)
Route::get('/', [HomeController::class, 'index']);

/*
|--------------------------------------------------------------------------
| RUTE KHUSUS ADMIN (WAJIB LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    
    // Rute Keamanan
    Route::post('/logout', [AuthController::class, 'logout']);

    // Rute Dashboard Utama
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Rute Manajemen Cabang
    Route::resource('/cabang', CabangController::class);
    
    // Transit Cabang (Kirim & Terima)
    Route::get('/transit/kirim', [TransitController::class, 'indexKirim']);
    Route::post('/transit/kirim', [TransitController::class, 'prosesKirim']);
    Route::get('/transit/terima', [TransitController::class, 'indexTerima']);
    Route::post('/transit/terima', [TransitController::class, 'prosesTerima']);
        
    // Manajemen Akun Hierarki
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/create', [UserController::class, 'create']);
    Route::post('/users', [UserController::class, 'store']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
    Route::get('/users/{id}/edit', [UserController::class, 'edit']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    
    // Rute Manajemen Kurir
    Route::get('/kurir', [KurirController::class, 'index']);
    Route::get('/kurir/create', [KurirController::class, 'create']);
    Route::post('/kurir', [KurirController::class, 'store']);
    // --- TAMBAHAN RUTE EDIT & UPDATE KURIR ---
    Route::get('/kurir/{id}/edit', [KurirController::class, 'edit']);
    Route::put('/kurir/{id}', [KurirController::class, 'update']);
    // -----------------------------------------
    Route::delete('/kurir/{id}', [KurirController::class, 'destroy']);
    
    // 1. Klaim Paket Baru
    Route::get('/kurir/antaran-saya', [KurirController::class, 'daftarAntaran']);
    Route::post('/kurir/klaim', [KurirController::class, 'klaimAntaran']);

    // 2. Paket Sedang Diantar
    Route::get('/kurir/antaran-aktif', [KurirController::class, 'antaranAktif']);
    Route::post('/kurir/selesaikan/{id}', [KurirController::class, 'selesaikanAntaran']);

    // Rute Manajemen Tarif
    Route::get('/tarif', [TarifController::class, 'index']);
    Route::get('/tarif/create', [TarifController::class, 'create']);
    Route::post('/tarif', [TarifController::class, 'store']);
    Route::get('/tarif/{id}/edit', [TarifController::class, 'edit']);
    Route::put('/tarif/{id}', [TarifController::class, 'update']);
    Route::delete('/tarif/{id}', [TarifController::class, 'destroy']);

    // Rute Manajemen Paket
    Route::get('/paket', [PaketController::class, 'index']);
    Route::get('/paket/create', [PaketController::class, 'create']);
    Route::post('/paket', [PaketController::class, 'store']);
    Route::get('/paket/{id}/edit', [PaketController::class, 'edit']);
    Route::put('/paket/{id}', [PaketController::class, 'update']);
    Route::delete('/paket/{id}', [PaketController::class, 'destroy']);
    Route::get('/paket/resi/{id}', [PaketController::class, 'cetakResi']);

    // Rute Jembatan Pengiriman & Tracking Admin
    Route::get('/pengiriman/create/{id_paket}', [PengirimanController::class, 'create']);
    Route::post('/pengiriman', [PengirimanController::class, 'store']);
    Route::post('/tracking', [TrackingController::class, 'store']);
    
    // Rute Cetak Resi
    Route::get('/paket/{id}/cetak', [PaketController::class, 'cetak_resi']);
    
    // Rute Laporan
    Route::get('/laporan', [LaporanController::class, 'index']);
    Route::post('/laporan/generate', [LaporanController::class, 'generate']);
});