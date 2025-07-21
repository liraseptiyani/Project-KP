<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DataBarangController extends Controller
{
    public function index()
    {
        $stokPerJenis = DB::table('barangs as b')
            ->join('jenis as j', 'b.jenis_id', '=', 'j.id')
            ->select('j.nama_jenis', DB::raw('COUNT(b.id) as total_stok'))
            ->groupBy('j.nama_jenis')
            ->get();

        return view('admin.data_barang.index', compact('stokPerJenis'));
    }
}



