<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Satuan;

class SatuanController extends Controller
{
    public function index()
    {
        $satuanBarang = Satuan::all(); // Ganti nama variabel agar sesuai dengan di view
        return view('admin.satuan.index', compact('satuanBarang'));
    }

    public function create()
    {
        return view('admin.satuan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'satuan' => 'required|string|max:100',
            'keterangan' => 'nullable|string|max:255',
        ]);

        Satuan::create($request->all());

        return redirect()->route('satuan.index')->with('success', 'Data satuan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $satuan = Satuan::findOrFail($id);
        return view('admin.satuan.edit', compact('satuan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'satuan' => 'required|string|max:100',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $satuan = Satuan::findOrFail($id);
        $satuan->update($request->all());

        return redirect()->route('satuan.index')->with('success', 'Data satuan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $satuan = Satuan::findOrFail($id);
        $satuan->delete();

        return redirect()->route('satuan.index')->with('success', 'Data satuan berhasil dihapus.');
    }
}
