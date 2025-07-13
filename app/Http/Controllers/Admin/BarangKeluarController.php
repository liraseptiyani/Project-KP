<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class BarangKeluarController extends Controller
{
    public function index()
    {
        return view('admin.barang_keluar.index');
    }
}