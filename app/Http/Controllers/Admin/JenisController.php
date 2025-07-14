<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jenis;

class JenisController extends Controller
{
    public function index()
    {
        $jenisBarang = Jenis::all();
        return view('admin.jenis.index', compact('jenisBarang'));
    }

    public function create()
    {
        return view('admin.jenis.create');
    }

    public function store(Request $request)
    {
        Jenis::create($request->only(['nama_jenis', 'keterangan']));
        return redirect()->route('jenis.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jenis = Jenis::findOrFail($id);
        return view('admin.jenis.edit', compact('jenis'));
    }

    public function update(Request $request, $id)
    {
        Jenis::findOrFail($id)->update($request->only(['nama_jenis', 'keterangan']));
        return redirect()->route('jenis.index')->with('success', 'Data berhasil diupdate.');
    }

    public function destroy($id)
    {
        Jenis::destroy($id);
        return redirect()->route('jenis.index')->with('success', 'Data berhasil dihapus.');
    }
}
