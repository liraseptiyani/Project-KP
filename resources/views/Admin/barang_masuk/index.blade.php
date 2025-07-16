@extends('layouts.app-admin')

@section('title', 'Barang Masuk')

@push('styles')
<style>
.container {
    max-width: 960px;
    background-color: white;
    padding: 25px 30px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    margin: 30px auto;
}

/* Judul di tengah */
h2 {
    color: #388E3C;
    margin-bottom: 20px;
    text-align: center;
}

/* Baris tombol: flex untuk posisikan tombol di kanan */
.button-row {
    display: flex;
    justify-content: flex-end; /* tombol ke kanan */
    margin-bottom: 20px;
}

a.btn-tambah {
    background-color: #388E3C;
    color: white;
    padding: 8px 18px;
    font-weight: bold;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    display: inline-block;
}

a.btn-tambah:hover {
    background-color: #2e7d32;
}

/* Lebarkan tabel dan beri scroll jika perlu */
.table-wrapper {
    display: block;
    overflow-x: auto;
}

table.table-barang {
    width: 100%;
    min-width: 1100px;
    border-collapse: collapse;
    margin-bottom: 30px;
}

/* Tombol aksi */
.aksi-buttons {
    display: flex;
    gap: 8px;
}

.btn-aksi {
    background-color: #1976d2;
    color: white;
    padding: 5px 12px;
    font-size: 13px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    white-space: nowrap;
}

.btn-aksi:hover {
    background-color: #115293;
}

.btn-hapus {
    background-color: #d32f2f;
}

.btn-hapus:hover {
    background-color: #9a2323;
}

table.table-barang th,
table.table-barang td {
    border: 1px solid #ccc;
    padding: 10px;
    text-align: left;
    vertical-align: middle;
}

table.table-barang th {
    background-color: #388E3C;
    color: white;
}

.alert-success {
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    padding: 10px 15px;
    border-radius: 5px;
    color: #155724;
    margin-bottom: 20px;
    text-align: center;
}

.qr-container {
    text-align: center;
}

.qr-container img {
    width: 100px;
    height: 100px;
    margin-bottom: 5px;
    border: 1px solid #ccc;
    background: #fff;
    padding: 4px;
    border-radius: 6px;
}

.qr-container a {
    font-size: 12px;
    color: white;
    background-color: #388E3C;
    padding: 4px 8px;
    border-radius: 4px;
    text-decoration: none;
    display: inline-block;
}

.qr-container a:hover {
    background-color: #2e7d32;
}
</style>
@endpush

@section('content')
<div class="container">
    <h2>Data Barang Masuk</h2>

    <div class="button-row">
        <a href="{{ route('barang-masuk.create') }}" class="btn-tambah">+ Tambah Barang Masuk</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-wrapper">
        <table class="table-barang">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Barang Masuk</th>
                    <th>Kode Barang</th>
                    <th>Jenis</th>
                    <th>Seri</th>
                    <th>Satuan</th>
                    <th>Lokasi</th>
                    <th>Tanggal Masuk</th>
                    <th>QR Code</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($barangMasuk as $bm)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $bm->id }}</td>
                        <td>{{ $bm->barang->kode_barang ?? '-' }}</td>
                        <td>{{ $bm->barang->jenis->nama_jenis ?? '-' }}</td>
                        <td>{{ $bm->barang->seri_barang ?? '-' }}</td>
                        <td>{{ $bm->barang->satuan->satuan ?? '-' }}</td>
                        <td>{{ $bm->barang->lokasi->lokasi ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($bm->tanggal_masuk)->format('d-m-Y') }}</td>
                        <td>
                            @php
                                $qrPath = Storage::url('qrcode/qrcode_barang_masuk_' . $bm->id . '.png');
                            @endphp
                            <div class="qr-container">
                                <img src="{{ $qrPath }}" alt="QR Code Barang Masuk {{ $bm->id }}">
                                <br>
                                <a href="{{ $qrPath }}" download="qrcode_barang_masuk_{{ $bm->id }}.png">Download</a>
                            </div>
                        </td>
                        <td>
                            <div class="aksi-buttons">
                                <a href="{{ route('barang-masuk.edit', $bm->id) }}" class="btn-aksi">Edit</a>

                                <form action="{{ route('barang-masuk.destroy', $bm->id) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus data ini?');" style="margin:0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-aksi btn-hapus">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" style="text-align: center;">Belum ada data barang masuk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
