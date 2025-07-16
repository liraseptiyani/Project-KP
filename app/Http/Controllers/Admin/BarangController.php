<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Jenis;
use App\Models\Satuan;
use App\Models\Lokasi;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barangList = Barang::with(['jenis', 'satuan', 'lokasi'])->get();
        return view('admin.barang.index', compact('barangList'));
    }

    public function create()
{
    $jenisList = Jenis::all();
    $satuanList = Satuan::all();
    $lokasiList = Lokasi::all();

    // Generate kode_barang: BRG-0001, BRG-0002, dst
    $lastBarang = Barang::orderByDesc('id')->first();
    $lastKodeNumber = 0;
    if ($lastBarang && preg_match('/BRG-(\d+)/', $lastBarang->kode_barang, $matches)) {
        $lastKodeNumber = (int) $matches[1];
    }
    $kodeBarang = 'BRG-' . str_pad($lastKodeNumber + 1, 4, '0', STR_PAD_LEFT);

    // Generate seri_barang: SR-A001, SR-A002, dst
    $lastSeriNumber = 0;
    if ($lastBarang && preg_match('/SR-A(\d+)/', $lastBarang->seri_barang, $matches)) {
        $lastSeriNumber = (int) $matches[1];
    }
    $seriBarang = 'SR-A' . str_pad($lastSeriNumber + 1, 3, '0', STR_PAD_LEFT);

    return view('admin.barang.create', compact(
        'jenisList', 'satuanList', 'lokasiList', 'kodeBarang', 'seriBarang'
    ));
}

    public function store(Request $request)
    {
        $request->validate([
            'jenis_id' => 'required|exists:jenis,id',
            'satuan_id' => 'required|exists:satuans,id', // ✅ harus plural
            'lokasi_id' => 'required|exists:lokasis,id', // ✅ harus plural
        ]);

        Barang::create([
            'kode_barang' => $request->kode_barang,
            'seri_barang' => $request->seri_barang,
            'jenis_id' => $request->jenis_id,
            'satuan_id' => $request->satuan_id,
            'lokasi_id' => $request->lokasi_id,
        ]);

        return redirect()->route('barang.index')->with('success', 'Data barang berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $jenisList = Jenis::all();
        $satuanList = Satuan::all();
        $lokasiList = Lokasi::all();

        return view('admin.barang.edit', compact('barang', 'jenisList', 'satuanList', 'lokasiList'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_id' => 'required|exists:jenis,id',
            'satuan_id' => 'required|exists:satuans,id', // ✅
            'lokasi_id' => 'required|exists:lokasis,id', // ✅
        ]);

        $barang = Barang::findOrFail($id);

        $barang->update([
            'jenis_id' => $request->jenis_id,
            'satuan_id' => $request->satuan_id,
            'lokasi_id' => $request->lokasi_id,
        ]);

        return redirect()->route('barang.index')->with('success', 'Data barang berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Data barang berhasil dihapus.');
    }
}
