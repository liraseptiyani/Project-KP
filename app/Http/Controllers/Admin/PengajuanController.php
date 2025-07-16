<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PengajuanController extends Controller
{
    public function index()
    {
        // Jika admin, tampilkan semua pengajuan
        if (auth()->user()->role === 'admin') {
            $pengajuans = PengajuanBarang::all();
        } else {
            // Jika user, tampilkan hanya milik sendiri
            $pengajuans = PengajuanBarang::where('user_id', auth()->id())->get();
        }

        return view(auth()->user()->role === 'admin' ? 'admin.pengajuan.index' : 'pengajuan.index', compact('pengajuans'));
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
            'id_peminjaman' => 'PGM-' . strtoupper(Str::random(6)),
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'nama_peminjam' => $request->nama_peminjam,
            'divisi' => auth()->user()->username,
            'nama_barang' => $request->nama_barang,
            'jumlah_barang' => $request->jumlah_barang,
            'user_id' => auth()->id(),
            'status' => 'menunggu'
        ]);

        return back()->with('success', 'Pengajuan berhasil dikirim.');
    }

    public function edit($id)
    {
        $pengajuan = PengajuanBarang::findOrFail($id);

        if (auth()->user()->role === 'admin') {
            return view('admin.pengajuan.edit', compact('pengajuan'));
        }

        if ($pengajuan->user_id !== auth()->id() || $pengajuan->status !== 'menunggu') {
            abort(403);
        }

        return view('pengajuan.edit', compact('pengajuan'));
    }

    public function update(Request $request, $id)
    {
        $pengajuan = PengajuanBarang::findOrFail($id);

        if (auth()->user()->role === 'admin') {
            $request->validate([
                'status' => 'required|in:menunggu,diterima,ditolak',
                'catatan' => 'nullable|string',
            ]);

            $pengajuan->update([
                'status' => $request->status,
                'catatan' => $request->catatan,
            ]);

            return redirect()->route('admin.pengajuan.index')->with('success', 'Pengajuan diperbarui.');
        }

        if ($pengajuan->user_id !== auth()->id() || $pengajuan->status !== 'menunggu') {
            abort(403);
        }

        $request->validate([
            'tanggal_peminjaman' => 'required|date',
            'tanggal_pengembalian' => 'required|date|after_or_equal:tanggal_peminjaman',
            'nama_peminjam' => 'required|string|max:100',
            'nama_barang' => 'required|string',
            'jumlah_barang' => 'required|integer|min:1',
        ]);

        $pengajuan->update([
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'nama_peminjam' => $request->nama_peminjam,
            'nama_barang' => $request->nama_barang,
            'jumlah_barang' => $request->jumlah_barang,
        ]);

        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil diubah.');
    }

    public function destroy($id)
    {
        $pengajuan = PengajuanBarang::findOrFail($id);

        if (auth()->user()->role !== 'admin' && ($pengajuan->user_id !== auth()->id() || $pengajuan->status !== 'menunggu')) {
            abort(403);
        }

        $pengajuan->delete();
        return back()->with('success', 'Pengajuan berhasil dihapus.');
    }
}
