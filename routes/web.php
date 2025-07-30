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
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PengajuanController; //controller admin
use App\Http\Controllers\PengajuanBarangController; //controller user
use App\Http\Controllers\StokBarangController;


// Redirect ke login jika akses root
Route::get('/', function () {
    return redirect('/login');
});

// Login & Logout
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// ✅ Tambahkan di sini
Route::get('/api/get-barang-by-jenis/{jenisId}', function($jenisId) {
    $barang = \App\Models\Barang::with('satuan', 'lokasi')
        ->where('jenis_id', $jenisId)
        ->first();

    return response()->json($barang);
})->middleware('auth');

// Admin Dashboard
// Route::get('/admin/dashboard', function () {
//     return view('admin.dashboard');
// })->middleware('auth');

// User Dashboard (sudah tidak dipakai karena user langsung diarahkan ke /pengajuan)
Route::get('/user/dashboard', function () {
    return view('user.dashboard');
})->middleware('auth');

//=============================//
//      ROUTE UNTUK ADMIN      //
//=============================//
//segala jenis admin
Route::prefix('admin')->name('admin.')->middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});


Route::middleware(['auth', 'is_admin'])->group(function () {

    // Master Data
    Route::resource('jenis', JenisController::class);
    Route::resource('satuan', SatuanController::class);
    Route::resource('lokasi', LokasiController::class);
    Route::resource('barang', BarangController::class);

    Route::get('/barang/generate-seri/{prefix}', [BarangController::class, 'generateSeri']);



    // 🔍 Tambahkan ini untuk Ajax ambil data barang by kode_barang (dari QR Code)
  Route::get('/barang/{id}/download-qr', [BarangController::class, 'cetakPdfQr'])->name('admin.barang.qrcode.pdf');




    // Barang Masuk
     Route::get('/data-barang', [DataBarangController::class, 'index'])->name('data-barang.index');
    Route::get('/get-barang-by-jenis/{id}', [BarangController::class, 'getBarangByJenis']);
    Route::get('/get-barang-detail/{id}', [BarangController::class, 'getBarangDetail']);
    Route::get('/admin/barang-masuk/export-pdf', [BarangMasukController::class, 'exportPDF'])->name('barang_masuk.export_pdf');
    Route::get('/barang-masuk', [BarangMasukController::class, 'index'])->name('barang-masuk.index');
    Route::get('/barang-masuk/create', [BarangMasukController::class, 'create'])->name('barang-masuk.create');
    Route::get('/barang-masuk/{id}/edit', [BarangMasukController::class, 'edit'])->name('barang-masuk.edit');
    Route::put('/barang-masuk/{id}', [BarangMasukController::class, 'update'])->name('barang-masuk.update');
    Route::resource('barang-masuk', BarangMasukController::class);






    // Barang Keluar
    Route::resource('barang-keluar', BarangKeluarController::class);
    Route::get('/barang-keluar/export/pdf', [BarangKeluarController::class, 'exportPdf'])->name('barang-keluar.export.pdf');

    // Data Barang
    Route::get('/data-barang', [DataBarangController::class, 'index'])->name('databarang.index');

    /// Pengajuan
    Route::get('/pengajuan', [PengajuanController::class, 'index'])->name('pengajuan.index');
    // Pengajuan khusus admin
    Route::prefix('admin')->group(function () {
        Route::get('/pengajuan', [PengajuanController::class, 'index'])->name('admin.pengajuan.index');
    });
    Route::put('/admin/pengajuan/{id}/update-status', [AdminController::class, 'updateStatus'])->name('admin.pengajuan.updateStatus');
    Route::post('/admin/pengajuan/verifikasi', [AdminController::class, 'verifikasi'])->name('admin.pengajuan.verifikasi');

    // Logout
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/login');
    })->name('logout');
});

//=============================//
//      ROUTE UNTUK USER       //
//=============================//
Route::middleware(['auth'])->group(function () {
    // Pengajuan User
    Route::get('/pengajuan', [PengajuanBarangController::class, 'index'])->name('pengajuan.index');
    Route::post('/pengajuan', [PengajuanBarangController::class, 'store'])->name('pengajuan.store');
    Route::get('/pengajuan/{id}/edit', [PengajuanBarangController::class, 'edit'])->name('pengajuan.edit');
    Route::put('/pengajuan/{id}', [PengajuanBarangController::class, 'update'])->name('pengajuan.update');
    Route::delete('/pengajuan/{id}', [PengajuanBarangController::class, 'destroy'])->name('pengajuan.destroy');



    // Logout
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/login');
    })->name('logout');
});
