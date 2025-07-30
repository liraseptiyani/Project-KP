<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // ⬅️ tambahkan juga ini karena kamu pakai DB::table
use App\Models\Barang;
use App\Models\DataBarang; // ⬅️ INI YANG WAJIB BIAR TIDAK ERROR

class DataBarangController extends Controller
{
    public function index()
    {
        $stokPerJenis = DataBarang::with('jenis')->get();

        return view('admin.data_barang.index', compact('stokPerJenis'));
    }

    public function rekapStok()
    {
        $stokPerJenis = DB::table('barang_masuk')
            ->join('barangs', 'barang_masuk.barang_id', '=', 'barangs.id')
            ->join('jenis', 'barangs.jenis_id', '=', 'jenis.id')
            ->select('jenis.nama_jenis', DB::raw('SUM(barang_masuk.jumlah) as total_stok'))
            ->groupBy('jenis.nama_jenis')
            ->get();

        return view('admin.stok.index', compact('stokPerJenis'));
    }
}
