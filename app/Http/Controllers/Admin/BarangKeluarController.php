<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\DataBarang;
use Barryvdh\DomPDF\Facade\Pdf;

class BarangKeluarController extends Controller
{
    public function index()
    {
        $barangKeluarList = BarangKeluar::with(['barang.jenis', 'barang.satuan', 'barang.lokasi'])->get();
        return view('admin.barang_keluar.index', compact('barangKeluarList'));
    }

    public function create()
    {
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

        $barang = Barang::where('seri_barang', $request->seri_barang)->first();

        if (!$barang) {
            return back()->with('error', 'Barang dengan seri tersebut tidak ditemukan.');
        }

        $dataBarang = DataBarang::where('jenis_id', $barang->jenis_id)->first();


        if (!$dataBarang) {
            return back()->with('error', 'Data stok barang tidak ditemukan.');
        }

        // Kurangi stok jika status dipinjam atau keluar
        if (in_array($request->status, ['dipinjam', 'keluar'])) {
            if ($dataBarang->total_stok <= 0) {
                return back()->with('error', 'Stok barang tidak mencukupi.');
            }

            $dataBarang->decrement('total_stok');
        }

        BarangKeluar::create([
            'barang_id' => $barang->id,
            'nama_peminjam' => $request->nama_peminjam,
            'status' => $request->status,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
        ]);

        return redirect()->route('barang-keluar.index')->with('success', 'Barang keluar berhasil dicatat.');
    }

    public function edit($id)
    {
        $barangKeluar = BarangKeluar::with('barang')->findOrFail($id);
        return view('admin.barang_keluar.edit', compact('barangKeluar'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_peminjam' => 'required|string|max:100',
            'status' => 'required|in:dipinjam,keluar,dikembalikan',
            'tanggal_pengembalian' => 'nullable|date',
        ]);

        $barangKeluar = BarangKeluar::findOrFail($id);
        $statusSebelumnya = $barangKeluar->status;
        $barang = $barangKeluar->barang;

        $dataBarang = DataBarang::where('jenis_id', $barang->jenis_id)->first();


        if (!$dataBarang) {
            return back()->with('error', 'Data stok barang tidak ditemukan.');
        }

        // Logika stok berdasarkan perubahan status
        if (in_array($statusSebelumnya, ['dipinjam', 'keluar']) && $request->status === 'dikembalikan') {
            $dataBarang->increment('total_stok');
        }

        if ($statusSebelumnya === 'dikembalikan' && in_array($request->status, ['dipinjam', 'keluar'])) {
            if ($dataBarang->total_stok <= 0) {
                return back()->with('error', 'Stok barang tidak mencukupi.');
            }
            $dataBarang->decrement('total_stok');
        }

        $barangKeluar->update([
            'nama_peminjam' => $request->nama_peminjam,
            'status' => $request->status,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
        ]);

        return redirect()->route('barang-keluar.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);
        $barangKeluar->delete();

        return redirect()->route('barang-keluar.index')->with('success', 'Data berhasil dihapus.');
    }

    public function exportPdf()
    {
        $barangKeluarList = BarangKeluar::with(['barang.jenis', 'barang.satuan', 'barang.lokasi'])->get();
        $pdf = Pdf::loadView('admin.barang_keluar.pdf', compact('barangKeluarList'));
        return $pdf->download('barang_keluar.pdf');
    }
}