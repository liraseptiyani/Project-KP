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
use App\Http\Controllers\Admin\PengajuanController; //controller admin
use App\Http\Controllers\PengajuanBarangController; //controller user

// Redirect ke login jika akses root
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

// User Dashboard (sudah tidak dipakai karena user langsung diarahkan ke /pengajuan)
Route::get('/user/dashboard', function () {
    return view('user.dashboard');
})->middleware('auth');

//=============================//
//      ROUTE UNTUK ADMIN      //
//=============================//
//segala jenis admin
Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

Route::middleware(['auth', 'is_admin'])->group(function () {

    Route::resource('jenis', JenisController::class);
    Route::resource('satuan', SatuanController::class);
    Route::resource('lokasi', LokasiController::class);
    Route::resource('barang', BarangController::class);


    Route::get('/barang-masuk', [BarangMasukController::class, 'index'])->name('barangmasuk.index');
    Route::resource('barang-keluar', BarangKeluarController::class);
    Route::get('/data-barang', [DataBarangController::class, 'index'])->name('databarang.index');
    Route::get('/pengajuan', [PengajuanController::class, 'index'])->name('pengajuan.index');

    
    Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('/pengajuan', [PengajuanController::class, 'index'])->name('admin.pengajuan.index');
    });

    Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');
});

//=============================//
//      ROUTE UNTUK USER       //
//=============================//
Route::middleware(['auth'])->group(function () {
    Route::get('/pengajuan', [PengajuanBarangController::class, 'index'])->name('pengajuan.index');
    Route::post('/pengajuan', [PengajuanBarangController::class, 'store'])->name('pengajuan.store');
    Route::get('/pengajuan/{id}/edit', [PengajuanBarangController::class, 'edit'])->name('pengajuan.edit');
    Route::put('/pengajuan/{id}', [PengajuanBarangController::class, 'update'])->name('pengajuan.update');
    Route::delete('/pengajuan/{id}', [PengajuanBarangController::class, 'destroy'])->name('pengajuan.destroy');

    Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');
});
