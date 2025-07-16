@extends('layouts.app-admin')

@section('title', 'Edit Barang Keluar')

@push('styles')
<style>
    .form-container {
        max-width: 600px;
        margin: 60px auto;
        background-color: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .form-container h3 {
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

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 8px 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
        box-sizing: border-box;
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
</style>
@endpush

@section('content')
<div class="form-container">
    <h3>Edit Barang Keluar</h3>

    <form action="{{ route('barangkeluar.update', $barangKeluar->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Barang --}}
        <input type="hidden" name="barang_id" value="{{ $barangKeluar->barang->id }}">

        <div class="form-group">
            <label>Kode Barang</label>
            <input type="text" value="{{ $barangKeluar->barang->kode_barang }}" readonly>
        </div>

        <div class="form-group">
            <label>Jenis</label>
            <input type="text" value="{{ $barangKeluar->barang->jenis->nama_jenis }}" readonly>
        </div>

        <div class="form-group">
            <label>Satuan</label>
            <input type="text" value="{{ $barangKeluar->barang->satuan->satuan }}" readonly>
        </div>

        <div class="form-group">
            <label>Lokasi</label>
            <input type="text" value="{{ $barangKeluar->barang->lokasi->lokasi }}" readonly>
        </div>

        <div class="form-group">
            <label>Nama Peminjam</label>
            <input type="text" name="nama_peminjam" value="{{ $barangKeluar->nama_peminjam }}" required>
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="status" required>
                <option value="">-- Pilih Status --</option>
                <option value="dipinjam" {{ $barangKeluar->status == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                <option value="keluar" {{ $barangKeluar->status == 'keluar' ? 'selected' : '' }}>Keluar</option>
                <option value="dikembalikan" {{ $barangKeluar->status == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
            </select>
        </div>

        <div class="form-group">
            <label>Tanggal Pengembalian</label>
            <input type="date" name="tanggal_pengembalian" value="{{ $barangKeluar->tanggal_pengembalian }}" required>
        </div>

        <button type="submit" class="btn-simpan">Update</button>
        <a href="{{ route('barang-keluar.index') }}" class="btn-batal">Batal</a>
    </form>
</div>
@endsection
