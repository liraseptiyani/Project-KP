<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DataBarangController extends Controller
{
    public function index()
    {
        return view('admin.data_barang.index');
    }
}
