@extends('layouts.app-admin')

@section('title', 'Stok Barang per Jenis')

@push('styles')
<style>
    .judul-halaman {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #000;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background-color: white;
    }

    th, td {
        padding: 12px;
        border: 1px solid #ddd;
        text-align: center;
        vertical-align: middle;
        font-size: 14px;
    }

    th {
        background-color: #388E3C;
        color: white;
        font-size: 15px;
    }

    tbody tr:hover {
        background-color: #f1f8f4;
    }
</style>
@endpush

@section('content')
    <h2 class="judul-halaman">Rekap Stok per Jenis Barang</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis Barang</th>
                <th>Total Stok</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($stokPerJenis as $index => $data)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $data->jenis->nama_jenis ?? '-' }}</td>
                    <td>{{ $data->total_stok }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align:center;">Belum ada data stok.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
