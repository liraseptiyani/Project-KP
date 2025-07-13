<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class BarangController extends Controller
{
    public function index()
    {
        return view('admin.barang.index');
    }
}