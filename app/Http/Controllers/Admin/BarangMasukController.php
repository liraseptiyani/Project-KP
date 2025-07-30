<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BarangMasuk;
use App\Models\Barang;
use App\Models\Jenis;
use App\Models\DataBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class BarangMasukController extends Controller
{
    public function index()
    {
        $barangMasuk = BarangMasuk::with('barang.jenis', 'barang.satuan', 'barang.lokasi')->get();
        return view('admin.barang_masuk.index', compact('barangMasuk'));
    }

    public function create()
    {
        $jenisList = Jenis::all();
        return view('admin.barang_masuk.create', compact('jenisList'));
    }

    public function getSeri($jenis_id)
    {
        $usedSeri = DB::table('barang_masuk')->pluck('barang_id')->toArray();

        $seri = Barang::where('jenis_id', $jenis_id)
            ->whereNotIn('id', $usedSeri)
            ->get();

        return response()->json($seri);
    }

    public function getBarangDetail($barangId)
    {
        $barang = Barang::with(['satuan', 'lokasi'])->find($barangId);

        if (!$barang) {
            return response()->json(['error' => 'Barang tidak ditemukan'], 404);
        }

        return response()->json([
            'id' => $barang->id,
            'seri_barang' => $barang->seri_barang,
            'satuan' => $barang->satuan->satuan,
            'lokasi' => $barang->lokasi->lokasi,
            'qr_code' => $barang->qr_code,
        ]);
    }

    public function store(Request $request)
{
    $request->validate([
        'barang_id' => 'required|exists:barangs,id',
        'jumlah' => 'required|integer|min:1',
        'tanggal_masuk' => 'required|date',
        'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    // Upload lampiran
    $lampiranName = null;
    if ($request->hasFile('lampiran')) {
        $file = $request->file('lampiran');
        $lampiranName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('storage/lampiran_barang_masuk'), $lampiranName);
    }

    // Simpan barang masuk
    $barangMasuk = BarangMasuk::create([
    'barang_id' => $request->barang_id,
    'jumlah' => $request->jumlah,
    'tanggal_masuk' => $request->tanggal_masuk,
    'lampiran' => $lampiranName,
]);

// ✅ Tambahkan ini
$barang = Barang::find($request->barang_id);
if ($barang) {
    $barang->stok += $request->jumlah;
    $barang->save();
}


    // ✅ Update atau insert ke data_barangs
    $jenisId = $barang->jenis_id;
    $dataBarang = DataBarang::where('jenis_id', $jenisId)->first();

    if ($dataBarang) {
        $dataBarang->increment('total_stok', $request->jumlah);
    } else {
        DataBarang::create([
            'jenis_id' => $jenisId,
            'total_stok' => $request->jumlah,
        ]);
    }

    return redirect()->route('barang-masuk.index')->with('success', 'Barang masuk berhasil dan stok diperbarui.');
}


    public function edit($id)
    {
        $barangMasuk = BarangMasuk::with('barang.jenis', 'barang.satuan', 'barang.lokasi')->findOrFail($id);
        $jenisList = Jenis::all();
        return view('admin.barang_masuk.edit', compact('barangMasuk', 'jenisList'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_masuk' => 'required|date',
            'barang_id' => 'required|exists:barangs,id',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $barangMasuk = BarangMasuk::findOrFail($id);
        $barangMasuk->tanggal_masuk = $request->tanggal_masuk;
        $barangMasuk->barang_id = $request->barang_id;

        if ($request->hasFile('lampiran')) {
            if ($barangMasuk->lampiran && Storage::disk('public')->exists('lampiran_barang_masuk/' . $barangMasuk->lampiran)) {
                Storage::disk('public')->delete('lampiran_barang_masuk/' . $barangMasuk->lampiran);
            }

            $path = $request->file('lampiran')->store('lampiran_barang_masuk', 'public');
            $barangMasuk->lampiran = basename($path);
        }

        $barangMasuk->save();

        return redirect()->route('barang-masuk.index')->with('success', 'Data barang masuk berhasil diperbarui.');
    }

   public function destroy($id)
{
    $barangMasuk = BarangMasuk::findOrFail($id);

    // Hapus lampiran jika ada
    if ($barangMasuk->lampiran && file_exists(public_path('storage/lampiran_barang_masuk/' . $barangMasuk->lampiran))) {
        unlink(public_path('storage/lampiran_barang_masuk/' . $barangMasuk->lampiran));
    }

    // Kurangi stok di tabel barangs
    $barang = Barang::find($barangMasuk->barang_id);
    if ($barang) {
        $barang->stok = max(0, $barang->stok - $barangMasuk->jumlah); // jangan minus
        $barang->save();
    }

    // Kurangi total_stok di data_barangs
    $dataBarang = DataBarang::where('jenis_id', $barang->jenis_id)->first();
    if ($dataBarang) {
        $dataBarang->total_stok = max(0, $dataBarang->total_stok - $barangMasuk->jumlah);
        $dataBarang->save();
    }

    $barangMasuk->delete();

    return redirect()->route('barang-masuk.index')->with('success', 'Data barang masuk berhasil dihapus dan stok dikurangi.');
}

    public function exportPDF()
    {
        $data = BarangMasuk::with('barang.jenis', 'barang.satuan', 'barang.lokasi')->get();
        $pdf = Pdf::loadView('admin.barang_masuk.pdf', compact('data'));
        return $pdf->download('laporan-barang-masuk.pdf');
    }

   public function rekapStok()
{
    $stokPerJenis = DB::table('barang_masuk')
        ->join('barangs', 'barang_masuk.barang_id', '=', 'barangs.id')
        ->join('jenis', 'barangs.jenis_id', '=', 'jenis.id')
        ->select('jenis.nama_jenis', DB::raw('SUM(barang_masuk.jumlah) as total_stok'))
        ->groupBy('jenis.nama_jenis')
        ->get();

    return view('admin.stok.index', compact('stokPerJenis'));
}

}
