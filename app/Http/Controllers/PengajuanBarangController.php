<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanBarang;
use Illuminate\Support\Str;

class PengajuanBarangController extends Controller
{
    public function index()
    {
        // Menampilkan hanya pengajuan berdasarkan divisi (dari username user login)
        $pengajuans = PengajuanBarang::where('divisi', auth()->user()->username)->get();

        return view('user.pengajuan.index', compact('pengajuans'));
    }

    private function generateIdPeminjaman()
    {
        $last = PengajuanBarang::orderBy('created_at', 'desc')->first();
        $lastNumber = 0;

        if ($last && preg_match('/PGM-(\d{4})$/', $last->id_peminjaman, $matches)) {
            $lastNumber = intval($matches[1]);
        }

        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        return 'PGM-' . $newNumber;
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_peminjaman' => 'required|date',
            'tanggal_pengembalian' => 'required|date|after_or_equal:tanggal_peminjaman',
            'nama_peminjam' => 'required|string|max:100',
            'nama_barang' => 'required|string',
            'jumlah_barang' => 'required|integer|min:1',
        ]);

        PengajuanBarang::create([
            'id_peminjaman' => $this->generateIdPeminjaman(),
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'nama_peminjam' => $request->nama_peminjam,
            'divisi' => auth()->user()->username,
            'nama_barang' => $request->nama_barang,
            'jumlah_barang' => $request->jumlah_barang,
            'status' => 'menunggu'
        ]);

        return back()->with('success', 'Pengajuan berhasil dikirim.');
    }

    public function edit($id)
    {
        $pengajuan = PengajuanBarang::findOrFail($id);

        if ($pengajuan->divisi !== auth()->user()->username || $pengajuan->status !== 'menunggu') {
            abort(403);
        }

        return view('user.pengajuan.edit', compact('pengajuan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_peminjam' => 'required|string|max:255',
            'tanggal_peminjaman' => 'required|date_format:d/m/Y',
            'tanggal_pengembalian' => 'required|date_format:d/m/Y|after_or_equal:tanggal_peminjaman',
            'nama_barang' => 'required|string|max:255',
            'jumlah_barang' => 'required|integer|min:1',
        ]);

        $pengajuan = PengajuanBarang::findOrFail($id);

        $pengajuan->nama_peminjam = $request->nama_peminjam;
        $pengajuan->tanggal_peminjaman = \Carbon\Carbon::createFromFormat('d/m/Y', $request->tanggal_peminjaman)->format('Y-m-d');
        $pengajuan->tanggal_pengembalian = \Carbon\Carbon::createFromFormat('d/m/Y', $request->tanggal_pengembalian)->format('Y-m-d');
        $pengajuan->nama_barang = $request->nama_barang;
        $pengajuan->jumlah_barang = $request->jumlah_barang;

        $pengajuan->save();

        return redirect()->route('pengajuan.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pengajuan = PengajuanBarang::findOrFail($id);

        if ($pengajuan->divisi !== auth()->user()->username || $pengajuan->status !== 'menunggu') {
            abort(403);
        }

        $pengajuan->delete();
        return back()->with('success', 'Pengajuan berhasil dihapus.');
    }
}
