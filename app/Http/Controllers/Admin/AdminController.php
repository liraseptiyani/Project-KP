<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanBarang;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,disetujui,ditolak',
            'catatan' => 'nullable|string',
        ]);

        $pengajuan = PengajuanBarang::findOrFail($id);
        $pengajuan->status = $request->status;
        $pengajuan->catatan = $request->input('catatan'); // ✅ ini perbaikannya
        $pengajuan->save();

        return redirect()->back()->with('success', 'Status dan catatan berhasil diperbarui.');
    }

    public function verifikasi(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:pengajuan_barangs,id',
            'status' => 'required|in:disetujui,ditolak',
            'catatan' => 'nullable|string',
        ]);

        $pengajuan = PengajuanBarang::find($request->id);
        $pengajuan->status = $request->status;
        $pengajuan->catatan = $request->catatan;
        $pengajuan->save();

        return redirect()->back()->with('success', 'Pengajuan berhasil diverifikasi.');
    }
}