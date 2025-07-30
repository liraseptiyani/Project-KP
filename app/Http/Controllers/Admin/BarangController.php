<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Jenis;
use App\Models\Satuan;
use App\Models\Lokasi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BarangController extends Controller
{
    // Daftar barang
    public function index()
    {
        $barangList = Barang::with(['jenis', 'satuan', 'lokasi'])->get();
        $jenisList = Jenis::all();
        $satuanList = Satuan::all();
        $lokasiList = Lokasi::all();

        return view('admin.barang.index', compact('barangList', 'jenisList', 'satuanList', 'lokasiList'));
    }

    // Form tambah barang
    public function create()
    {
        $jenisList = Jenis::all();
        $satuanList = Satuan::all();
        $lokasiList = Lokasi::all();

        return view('admin.barang.create', compact('jenisList', 'satuanList', 'lokasiList'));
    }

    // Simpan barang baru
    public function store(Request $request)
    {
        $request->validate([
            'jenis_id' => 'required|exists:jenis,id',
            'satuan_id' => 'required|exists:satuans,id',
            'lokasi_id' => 'required|exists:lokasis,id',
            'seri_barang' => 'required|string|unique:barangs,seri_barang',
        ]);

        $jenis = Jenis::find($request->jenis_id);
        $seri_barang = strtoupper($request->seri_barang);

        preg_match('/\d+$/', $seri_barang, $matches);
        $noUrut = isset($matches[0]) ? (int)$matches[0] : 1;

        $qrData = json_encode([
            'seri_barang' => $seri_barang,
            'jenis' => $jenis->nama_jenis,
            'satuan' => Satuan::find($request->satuan_id)?->satuan ?? '',
            'lokasi' => Lokasi::find($request->lokasi_id)?->lokasi ?? '',
            'tanggal_input' => now()->format('Y-m-d H:i:s'),
        ]);

        $qrImage = QrCode::format('svg')->size(300)->generate($qrData);
        $fileName = 'qr_' . time() . '_' . Str::random(5) . '.svg';
        Storage::disk('public')->put('qr/' . $fileName, $qrImage);

        Barang::create([
            'jenis_id' => $request->jenis_id,
            'satuan_id' => $request->satuan_id,
            'lokasi_id' => $request->lokasi_id,
            'seri_barang' => $seri_barang,
            'no_urut' => $noUrut,
            'qr_code' => $fileName,
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    // Form edit barang
    public function edit($id)
    {
        $barang = Barang::with(['jenis', 'satuan', 'lokasi'])->findOrFail($id);
        $jenisList = Jenis::all();
        $satuanList = Satuan::all();
        $lokasiList = Lokasi::all();

        return view('admin.barang.edit', compact('barang', 'jenisList', 'satuanList', 'lokasiList'));
    }

    // Update barang
    public function update(Request $request, $id)
    {
        $request->validate([
            'seri_barang' => 'required|string|unique:barangs,seri_barang,' . $id,
            'jenis_id' => 'required|exists:jenis,id',
            'satuan_id' => 'required|exists:satuans,id',
            'lokasi_id' => 'required|exists:lokasis,id',
        ]);

        $barang = Barang::findOrFail($id);
        $barang->update([
            'seri_barang' => strtoupper($request->seri_barang),
            'jenis_id' => $request->jenis_id,
            'satuan_id' => $request->satuan_id,
            'lokasi_id' => $request->lokasi_id,
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diupdate.');
    }

    // Hapus barang
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        if ($barang->qr_code && Storage::disk('public')->exists('qr/' . $barang->qr_code)) {
            Storage::disk('public')->delete('qr/' . $barang->qr_code);
        }

        $barang->delete();
        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }

    // Generate nomor seri otomatis
    public function generateSeri($prefix)
    {
        $latest = Barang::where('seri_barang', 'LIKE', $prefix . '%')
                        ->orderBy('no_urut', 'desc')
                        ->first();

        $noUrut = $latest ? $latest->no_urut + 1 : 1;
        $seri_barang = $prefix . str_pad($noUrut, 3, '0', STR_PAD_LEFT);

        return response()->json(['seri_barang' => $seri_barang]);
    }

    // API: Dropdown berdasarkan jenis
    public function getBarangByJenis($id)
    {
        $barang = Barang::where('jenis_id', $id)
            ->whereNotIn('id', function($query) {
                $query->select('barang_id')->from('barang_masuk');
            })
            ->get(['id', 'seri_barang']);

        return response()->json($barang);
    }

    // API: Detail barang
    public function getBarangDetail($id)
    {
        $barang = Barang::with(['satuan', 'lokasi'])->findOrFail($id);

        return response()->json([
            'satuan' => $barang->satuan->satuan ?? '',
            'lokasi' => $barang->lokasi->lokasi ?? '',
            'qrcode' => $barang->qr_code ?? ''
        ]);
    }
}
