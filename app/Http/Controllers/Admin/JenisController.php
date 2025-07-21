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
        $request->validate([
            'nama_jenis' => 'required|string|max:100',
            'prefix' => 'required|string|max:5',
            'keterangan' => 'nullable|string',
        ]);

        Jenis::create($request->only(['nama_jenis', 'prefix', 'keterangan']));

        return redirect()->route('jenis.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jenis = Jenis::findOrFail($id);
        return view('admin.jenis.edit', compact('jenis'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:100',
            'prefix' => 'required|string|max:5',
            'keterangan' => 'nullable|string',
        ]);

        Jenis::findOrFail($id)->update($request->only(['nama_jenis', 'prefix', 'keterangan']));

        return redirect()->route('jenis.index')->with('success', 'Data berhasil diupdate.');
    }

    public function destroy($id)
    {
        Jenis::destroy($id);
        return redirect()->route('jenis.index')->with('success', 'Data berhasil dihapus.');
    }
}
