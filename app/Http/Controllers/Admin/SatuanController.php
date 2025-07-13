<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class SatuanController extends Controller
{
    public function index()
    {
        return view('admin.satuan.index');
    }
}