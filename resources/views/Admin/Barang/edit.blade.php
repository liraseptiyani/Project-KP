@extends('layouts.app-admin')

@section('title', 'Edit Barang')

@push('styles')
<style>
    .form-container {
        max-width: 500px;
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

    .btn-simpan:hover {
        background-color: #2e7d32;
    }

    .btn-batal:hover {
        background-color: #c62828;
    }
</style>
@endpush

@section('content')
<div class="form-container">
    <h3>Edit Barang</h3>
    <form action="{{ route('barang.update', $barang->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Kode Barang</label>
            <input type="text" name="kode_barang" value="{{ $barang->kode_barang }}" readonly>
        </div>

        <div class="form-group">
            <label>Seri Barang</label>
            <input type="text" name="seri_barang" value="{{ $barang->seri_barang }}" readonly>
        </div>

        <div class="form-group">
            <label>Jenis</label>
            <select name="jenis_id" required>
                @foreach ($jenisList as $jenis)
                    <option value="{{ $jenis->id }}" {{ $barang->jenis_id == $jenis->id ? 'selected' : '' }}>
                        {{ $jenis->nama_jenis }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Satuan</label>
            <select name="satuan_id" required>
                @foreach ($satuanList as $satuan)
                    <option value="{{ $satuan->id }}" {{ $barang->satuan_id == $satuan->id ? 'selected' : '' }}>
                        {{ $satuan->satuan }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Lokasi</label>
            <select name="lokasi_id" required>
                @foreach ($lokasiList as $lokasi)
                    <option value="{{ $lokasi->id }}" {{ $barang->lokasi_id == $lokasi->id ? 'selected' : '' }}>
                        {{ $lokasi->lokasi }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn-simpan">Simpan Perubahan</button>
        <a href="{{ route('barang.index') }}" class="btn-batal">Batal</a>
    </form>
</div>
@endsection
