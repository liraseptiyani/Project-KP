@extends('layouts.app-admin')

@section('title', 'Stok Barang per Jenis')

@push('styles')
<style>
    h2 {
        color: #388E3C;
    }

    .table-wrapper {
        background-color: white;
        padding: 25px 30px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        margin: 30px auto;
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

    td {
        text-align: center;
    }
</style>
@endpush

@section('content')
<div class="table-wrapper">
    <h2>Rekap Stok per Jenis Barang</h2>
    <p>Halaman ini menampilkan total stok berdasarkan jenis barang.</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis Barang</th>
                <th>Total Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stokPerJenis as $index => $data)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $data->nama_jenis }}</td>
                    <td>{{ $data->total_stok }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
