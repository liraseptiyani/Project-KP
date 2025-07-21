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
        $barangKeluarList = BarangKeluar::with(['barang.jenis', 'barang.satuan', 'barang.lokasi'])->get();
        return view('admin.barang_keluar.index', compact('barangKeluarList'));
    }

    public function create()
    {
        // Tidak perlu kirim seluruh barang, hanya untuk scan QR
        return view('admin.barang_keluar.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'seri_barang' => 'required|string',
            'nama_peminjam' => 'required|string|max:100',
            'status' => 'required|in:dipinjam,keluar,dikembalikan',
            'tanggal_pengembalian' => 'nullable|date',
        ]);

        // Ambil barang berdasarkan seri_barang dari QR
        $barang = Barang::where('seri_barang', $request->seri_barang)->first();

        if (!$barang) {
            return back()->with('error', 'Barang dengan seri tersebut tidak ditemukan.');
        }

        // Simpan data barang keluar
        BarangKeluar::create([
            'barang_id' => $barang->id,
            'nama_peminjam' => $request->nama_peminjam,
            'status' => $request->status,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
        ]);

        // Jika status dikembalikan → stok bertambah
        if ($request->status === 'dikembalikan') {
            $barang->stok += 1;
            $barang->save();
        }

        return redirect()->route('barang-keluar.index')->with('success', 'Barang keluar berhasil dicatat.');
    }

    public function edit($id)
    {
        $barangKeluar = BarangKeluar::with('barang')->findOrFail($id);
        return view('admin.barang_keluar.edit', compact('barangKeluar'));
    }

    public function update(Request $request, $id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);

        $request->validate([
            'nama_peminjam' => 'required|string|max:100',
            'status' => 'required|in:dipinjam,keluar,dikembalikan',
            'tanggal_pengembalian' => 'nullable|date',
        ]);

        $barangKeluar->update([
            'nama_peminjam' => $request->nama_peminjam,
            'status' => $request->status,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
        ]);

        return redirect()->route('barang-keluar.index')->with('success', 'Data berhasil diperbarui.');
    }

    


}
