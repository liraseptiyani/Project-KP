<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\DataBarang;
use App\Models\PengajuanBarang;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalBarang' => Barang::count(),
            'totalMasuk' => BarangMasuk::count(),
            'totalKeluar' => BarangKeluar::count(),
            'totalData' => DataBarang::count(),
            'totalPengajuan' => PengajuanBarang::count(),
        ]);
    }
}
