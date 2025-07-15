<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BarangMasuk;

class BarangMasukController extends Controller
{
   public function index()
{
    $barangMasuk = \App\Models\BarangMasuk::with('barang')->get();
    return view('barang_masuk.index', compact('barangMasuk'));
}
}