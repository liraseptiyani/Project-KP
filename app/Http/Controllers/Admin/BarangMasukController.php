<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BarangMasuk;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BarangMasukController extends Controller
{
    public function index()
    {
        $barangMasuk = BarangMasuk::with('barang.jenis', 'barang.satuan', 'barang.lokasi')->get();
        return view('admin.barang_masuk.index', compact('barangMasuk'));
    }

    public function create()
    {
        $barangList = Barang::with(['jenis', 'satuan', 'lokasi'])->get();
        return view('admin.barang_masuk.create', compact('barangList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_masuk' => 'required|date',
            'kode_barang' => 'required|exists:barangs,id',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $barangMasuk = new BarangMasuk();
        $barangMasuk->tanggal_masuk = $request->tanggal_masuk;
        $barangMasuk->barang_id = $request->kode_barang;

        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('lampiran_barang_masuk'), $namaFile);
            $barangMasuk->lampiran = $namaFile;
        }

        $barangMasuk->save();

        return redirect()->route('barang-masuk.index')->with('success', 'Data barang masuk berhasil disimpan.');
    }

    public function edit($id)
{
    $barangMasuk = BarangMasuk::with('barang.jenis', 'barang.satuan', 'barang.lokasi')->findOrFail($id);
    return view('admin.barang_masuk.edit', compact('barangMasuk'));
}


    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_masuk' => 'required|date',
            'kode_barang' => 'required|exists:barangs,id',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $barangMasuk = BarangMasuk::findOrFail($id);
        $barangMasuk->tanggal_masuk = $request->tanggal_masuk;
        $barangMasuk->barang_id = $request->kode_barang;

        if ($request->hasFile('lampiran')) {
            if ($barangMasuk->lampiran && file_exists(public_path('lampiran_barang_masuk/' . $barangMasuk->lampiran))) {
                unlink(public_path('lampiran_barang_masuk/' . $barangMasuk->lampiran));
            }

            $file = $request->file('lampiran');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('lampiran_barang_masuk'), $namaFile);
            $barangMasuk->lampiran = $namaFile;
        }

        $barangMasuk->save();

        return redirect()->route('barang-masuk.index')->with('success', 'Data barang masuk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);

        if ($barangMasuk->lampiran && file_exists(public_path('lampiran_barang_masuk/' . $barangMasuk->lampiran))) {
            unlink(public_path('lampiran_barang_masuk/' . $barangMasuk->lampiran));
        }

        $barangMasuk->delete();

        return redirect()->route('barang-masuk.index')->with('success', 'Data barang masuk berhasil dihapus.');
    }
}
