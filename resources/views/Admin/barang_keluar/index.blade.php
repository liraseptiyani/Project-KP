@extends('layouts.app-admin')

@section('title', 'Barang Keluar')

@push('styles')
<style>
    .btn-tambah {
        background-color: #388E3C;
        color: white;
        font-weight: bold;
        padding: 8px 16px;
        border-radius: 5px;
        border: none;
        float: right;
        margin-bottom: 15px;
        transition: background-color 0.3s;
    }
    .btn-tambah:hover {
        background-color: #2e7d32;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        background-color: white;
    }
    th, td {
        padding: 12px;
        border: 1px solid #ddd;
    }
    th {
        background-color: #388E3C;
        color: white;
        text-align: center;
    }
    td.actions {
        text-align: center;
    }
    .btn-edit, .btn-hapus {
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 13px;
        color: white;
        text-decoration: none;
        margin: 2px;
    }
    .btn-edit { background-color: #1976D2; }
    .btn-edit:hover { background-color: #1565C0; }
    .btn-hapus { background-color: #D32F2F; }
    .btn-hapus:hover { background-color: #B71C1C; }
</style>
@endpush

@section('content')
<h2>Data Barang Keluar</h2>

<a href="{{ route('barang-keluar.create') }}" class="btn-tambah">+ Tambah Barang Keluar</a>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Barang</th>
            <th>Seri Barang</th>
            <th>Jenis</th>
            <th>Lokasi</th>
            <th>Nama Peminjam</th>
            <th>Tanggal Pengembalian</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($barangKeluarList as $index => $barang)
        <tr>
            <td style="text-align: center;">{{ $index + 1 }}</td>
            <td>{{ $barang->barang->kode_barang }}</td>
            <td>{{ $barang->barang->seri_barang }}</td>
            <td>{{ $barang->barang->jenis->nama_jenis ?? '-' }}</td>
            <td>{{ $barang->barang->lokasi->lokasi ?? '-' }}</td>
            <td>{{ $barang->nama_peminjam }}</td>
            <td>{{ $barang->tanggal_pengembalian }}</td>
            <td>{{ ucfirst($barang->status) }}</td>
            <td class="actions">
                <a href="{{ route('barang-keluar.edit', $barang->id) }}" class="btn-edit">Edit</a>
                <form action="{{ route('barang-keluar.destroy', $barang->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-hapus" onclick="return confirm('Yakin hapus data ini?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
