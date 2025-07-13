<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class LokasiController extends Controller
{
    public function index()
    {
        return view('admin.lokasi.index');
    }
}