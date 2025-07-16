@extends('layouts.app-user')

@section('title', 'Edit Pengajuan Barang')

@push('styles')
<style>
    .edit-container {
        max-width: 500px;
        margin: 100px auto;
        background-color: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .edit-container h3 {
        text-align: center;
        color: #388E3C;
        margin-bottom: 25px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
        color: #333;
    }

    .form-group input {
        width: 100%;
        padding: 8px 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
        font-size: 14px;
    }

    .btn-simpan {
        background-color: #388E3C;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        font-weight: bold;
        cursor: pointer;
        margin-right: 10px;
    }

    .btn-batal {
        background-color: #D32F2F;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        font-weight: bold;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-simpan:hover {
        background-color: #2e7d32;
    }

    .btn-batal:hover {
        background-color: #c62828;
    }
</style>
@endpush

@section('content')
<div class="edit-container">
    <h3>Edit Pengajuan Barang</h3>
    <form action="{{ route('pengajuan.update', $pengajuan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nama Peminjam</label>
            <input type="text" name="nama_peminjam" value="{{ old('nama_peminjam', $pengajuan->nama_peminjam) }}" required>
        </div>

        <div class="form-group">
            <label>Tanggal Peminjaman</label>
            <input type="text" name="tanggal_peminjaman" value="{{ old('tanggal_peminjaman', \Carbon\Carbon::parse($pengajuan->tanggal_peminjaman)->format('d/m/Y')) }}" required>
        </div>

        <div class="form-group">
            <label>Tanggal Pengembalian</label>
            <input type="text" name="tanggal_pengembalian" value="{{ old('tanggal_pengembalian', \Carbon\Carbon::parse($pengajuan->tanggal_pengembalian)->format('d/m/Y')) }}" required>
        </div>

        <div class="form-group">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" value="{{ old('nama_barang', $pengajuan->nama_barang) }}" required>
        </div>

        <div class="form-group">
            <label>Jumlah Barang</label>
            <input type="number" name="jumlah_barang" value="{{ old('jumlah_barang', $pengajuan->jumlah_barang) }}" required>
        </div>

        <button type="submit" class="btn-simpan">Update</button>
        <a href="{{ route('pengajuan.index') }}" class="btn-batal">Batal</a>
    </form>
</div>
@endsection
