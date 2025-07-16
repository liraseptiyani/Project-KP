<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\BarangKeluar;

class BarangKeluarController extends Controller
{
    public function index()
    {
        $barangKeluarList = BarangKeluar::with('barang')->get();
        return view('admin.barang_keluar.index', compact('barangKeluarList'));
    }

    public function create()
    {
        // ✅ WAJIB pakai with agar relasi bisa diakses di JavaScript
        $barangList = Barang::with(['jenis', 'satuan', 'lokasi'])->get();
        return view('admin.barang_keluar.create', compact('barangList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'nama_peminjam' => 'required|string|max:100',
            'status' => 'required|in:dipinjam,keluar,dikembalikan',
            'tanggal_pengembalian' => 'nullable|date',
        ]);

        BarangKeluar::create([
            'barang_id' => $request->barang_id,
            'nama_peminjam' => $request->nama_peminjam,
            'status' => $request->status,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
        ]);

        return redirect()->route('barang-keluar.index')->with('success', 'Barang keluar berhasil dicatat.');
    }

    public function edit($id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);
        $barangList = Barang::all();
        return view('admin.barang_keluar.edit', compact('barangKeluar', 'barangList'));
    }

    public function update(Request $request, $id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);

        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'nama_peminjam' => 'required|string|max:100',
            'status' => 'required|in:dipinjam,keluar,dikembalikan',
            'tanggal_pengembalian' => 'nullable|date',
        ]);

        $barangKeluar->update([
            'barang_id' => $request->barang_id,
            'nama_peminjam' => $request->nama_peminjam,
            'status' => $request->status,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
        ]);

        return redirect()->route('barang-keluar.index')->with('success', 'Data berhasil diperbarui.');
    }
}
