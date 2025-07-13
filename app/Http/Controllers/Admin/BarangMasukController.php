<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class BarangMasukController extends Controller
{
    public function index()
    {
        return view('admin.barang_masuk.index');
    }
}