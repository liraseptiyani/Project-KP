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


// segala jenis admin
Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

Route::middleware(['auth', 'is_admin'])->group(function () {

    Route::resource('jenis', JenisController::class);
    Route::resource('satuan', SatuanController::class);
    Route::resource('lokasi', LokasiController::class);
    Route::resource('barang', BarangController::class);


    // Route::get('/barang-masuk', [BarangMasukController::class, 'index'])->name('barangmasuk.index');
    Route::get('/barang-masuk', [BarangMasukController::class, 'index'])->name('barang-masuk.index');
    Route::get('/barang-masuk/create', [BarangMasukController::class, 'create'])->name('barang-masuk.create');
    Route::get('/barang-masuk/{id}/edit', [BarangMasukController::class, 'edit'])->name('barang-masuk.edit');
    Route::resource('barang-masuk', BarangMasukController::class);

    Route::resource('barang-keluar', BarangKeluarController::class);
    Route::get('/data-barang', [DataBarangController::class, 'index'])->name('databarang.index');
    Route::get('/pengajuan', [PengajuanController::class, 'index'])->name('pengajuan.index');

    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/login');
    })->name('logout');

});



