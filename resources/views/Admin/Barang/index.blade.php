@extends('layouts.app-admin')

@section('title', 'Data Barang')

@push('styles')
<style>
    .btn-tambah {
        background-color: #388E3C;
        color: white;
        font-weight: bold;
        padding: 8px 16px;
        border-radius: 5px;
        text-decoration: none;
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
        vertical-align: middle;
    }

    .btn-edit, .btn-hapus {
        padding: 5px 10px;
        border-radius: 4px;
        border: none;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        color: white;
        text-decoration: none;
        margin: 2px;
        display: inline-block;
    }

    .btn-edit {
        background-color: #1976D2;
    }

    .btn-edit:hover {
        background-color: #1565C0;
    }

    .btn-hapus {
        background-color: #D32F2F;
    }

    .btn-hapus:hover {
        background-color: #B71C1C;
    }
</style>
@endpush

@section('content')
<h2>Data Barang</h2>

<a href="{{ route('barang.create') }}" class="btn-tambah">+ Tambah Data</a>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Barang</th>
            <th>Seri Barang</th>
            <th>Jenis</th>
            <th>Satuan</th>
            <th>Lokasi</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($barangList as $index => $barang)
        <tr>
            <td style="text-align:center;">{{ $index + 1 }}</td>
            <td>{{ $barang->kode_barang }}</td>
            <td>{{ $barang->seri_barang }}</td>
            <td>{{ $barang->jenis->nama_jenis ?? '-' }}</td>
            <td>{{ $barang->satuan->satuan ?? '-' }}</td>
            <td>{{ $barang->lokasi->lokasi ?? '-' }}</td>
            <td class="actions">
                <a href="{{ route('barang.edit', $barang->id) }}" class="btn-edit">Edit</a>
                <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" style="display:inline;">
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
