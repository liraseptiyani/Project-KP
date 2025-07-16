<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BarangMasuk;
use App\Models\Barang;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class BarangMasukController extends Controller
{
    /**
     * Menampilkan daftar barang masuk
     */
    public function index()
{
    $barangMasuk = BarangMasuk::with('barang.jenis', 'barang.satuan', 'barang.lokasi')->get();
    return view('admin.barang_masuk.index', compact('barangMasuk'));
}

    /**
     * Menampilkan form tambah barang masuk
     */
    public function create()
{
    $barangList = Barang::with(['jenis', 'satuan', 'lokasi'])->get();
    return view('admin.barang_masuk.create', compact('barangList'));
}


    /**
     * Menyimpan data barang masuk
     */
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

        // Upload lampiran jika ada
        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('lampiran_barang_masuk'), $namaFile);
            $barangMasuk->lampiran = $namaFile;
        }

        $barangMasuk->save();

        // Generate QR Code untuk barang masuk, simpan ke folder storage/app/public/qrcode
       $qrData = [
    'id' => $barangMasuk->id,
    'kode_barang' => $barangMasuk->barang->kode_barang,
    'jenis' => $barangMasuk->barang->jenis->nama_jenis ?? '-',
    'seri' => $barangMasuk->barang->seri_barang ?? '-',
    'satuan' => $barangMasuk->barang->satuan->satuan ?? '-',
    'lokasi' => $barangMasuk->barang->lokasi->lokasi ?? '-',
    'tanggal_masuk' => \Carbon\Carbon::parse($barangMasuk->tanggal_masuk)->format('d-m-Y'),
];

$qrContent = json_encode($qrData);
$qrImage = QrCode::format('svg')->size(200)->generate($qrContent);

Storage::disk('public')->put('qrcode/qrcode_barang_masuk_' . $barangMasuk->id . '.svg', $qrImage);


        // Jika ada kolom qr_code di tabel barang_masuk, simpan nama file QR ke database (optional)
        // $barangMasuk->qr_code = $qrFileName;
        // $barangMasuk->save();

        return redirect()->route('barang-masuk.index')->with('success', 'Data barang masuk berhasil disimpan dan QR Code dibuat.');
    }
}
