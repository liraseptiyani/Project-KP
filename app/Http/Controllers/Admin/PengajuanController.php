<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanBarang;

class PengajuanController extends Controller
{

    public function index()
    {
        // Ambil semua pengajuan dari user
        $pengajuan = PengajuanBarang::orderBy('created_at', 'desc')->get();

        return view('admin.pengajuan.index', compact('pengajuan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,disetujui,ditolak',
        ]);

        $pengajuan = PengajuanBarang::findOrFail($id);
        $pengajuan->status = $request->status;
        $pengajuan->catatan = $request->catatan; // catatan opsional dari admin
        $pengajuan->save();

        return redirect()->back()->with('success', 'Status pengajuan berhasil diperbarui.');
    }

    public function verifikasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'catatan' => 'nullable|string',
        ]);

        $pengajuan = PengajuanBarang::findOrFail($id);
        $pengajuan->status = $request->status;
        $pengajuan->catatan = $request->catatan;
        $pengajuan->save();

        return redirect()->back()->with('success', 'Status pengajuan berhasil diperbarui.');
    }
}