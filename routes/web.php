<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\JenisController;
use App\Http\Controllers\Admin\SatuanController;
use App\Http\Controllers\Admin\LokasiController;
use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\Admin\BarangMasukController;
use App\Http\Controllers\Admin\BarangKeluarController;
use App\Http\Controllers\Admin\DataBarangController;
use App\Http\Controllers\Admin\PengajuanController;


Route::get('/', function () {
    return redirect('/login');
});


// Login & Logout
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin Dashboard
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware('auth');

// User Dashboard
Route::get('/user/dashboard', function () {
    return view('user.dashboard');
})->middleware('auth');


//segala jenis admin
Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::get('/jenis', [JenisController::class, 'index'])->name('jenis.index');
    Route::get('/satuan', [SatuanController::class, 'index'])->name('satuan.index');
    Route::get('/lokasi', [LokasiController::class, 'index'])->name('lokasi.index');
    Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');

    Route::get('/barang-masuk', [BarangMasukController::class, 'index'])->name('barangmasuk.index');
    Route::get('/barang-keluar', [BarangKeluarController::class, 'index'])->name('barangkeluar.index');
    Route::get('/data-barang', [DataBarangController::class, 'index'])->name('databarang.index');
     Route::get('/pengajuan', [PengajuanController::class, 'index'])->name('pengajuan.index');

    Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

});
