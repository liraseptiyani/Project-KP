<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    public function index()
{
    $lokasiBarang = Lokasi::all(); // Ambil semua data dari tabel lokasi
    return view('admin.lokasi.index', compact('lokasiBarang'));
}

    public function create()
    {
        return view('admin.lokasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'lokasi' => 'required|string|max:255',
        ]);

        Lokasi::create($request->all());
        return redirect()->route('lokasi.index')->with('success', 'Data lokasi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $lokasi = Lokasi::findOrFail($id);
        return view('admin.lokasi.edit', compact('lokasi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'lokasi' => 'required|string|max:255',
        ]);

        $lokasi = Lokasi::findOrFail($id);
        $lokasi->update($request->all());

        return redirect()->route('lokasi.index')->with('success', 'Data lokasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $lokasi = Lokasi::findOrFail($id);
        $lokasi->delete();

        return redirect()->route('lokasi.index')->with('success', 'Data lokasi berhasil dihapus.');
    }
}
