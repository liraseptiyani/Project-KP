@extends('layouts.app-admin')

@section('title', 'Edit Barang Masuk')

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

    label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
        color: #333;
    }

    input[type="date"],
    input[type="text"],
    input[type="file"],
    .form-control-plaintext {
        width: 100%;
        padding: 8px 10px;
        font-size: 14px;
        box-sizing: border-box;
        border-radius: 5px;
    }

    input[type="date"],
    input[type="file"] {
        border: 1px solid #ccc;
    }

    .form-control-plaintext {
        border: none;
        background-color: #f8f9fa;
        padding-left: 0;
    }

    .qr-preview {
        text-align: center;
        margin-top: 10px;
    }

    .qr-preview img {
        width: 120px;
        height: 120px;
        object-fit: contain;
        border: 1px solid #ddd;
        border-radius: 6px;
        background: white;
        padding: 6px;
        display: inline-block;
    }

    /* Style untuk tombol */
    .button-group {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 20px;
    }

    .btn-simpan {
        background-color: #388E3C;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .btn-simpan:hover {
        background-color: #2e7d32;
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
        transition: 0.2s ease;
    }

    .btn-batal:hover {
        background-color: #b71c1c;
    }
</style>
@endpush

@section('content')

<div class="form-container">
    <h3>Edit Barang Masuk</h3>

    <form action="{{ route('barang-masuk.update', $barangMasuk->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Input Tanggal Masuk --}}
        <div class="form-group">
            <label for="tanggal_masuk">Tanggal Masuk</label>
            <input type="date" id="tanggal_masuk" name="tanggal_masuk"
                   value="{{ old('tanggal_masuk', $barangMasuk->tanggal_masuk) }}" required>
            @error('tanggal_masuk')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Kode Barang (readonly) --}}
        <div class="form-group">
            <label>Kode Barang</label>
            <input type="text" class="form-control-plaintext" readonly value="{{ $barangMasuk->barang->kode_barang ?? 'N/A' }}">
            <input type="hidden" name="barang_id" value="{{ $barangMasuk->barang->id }}">
            @error('barang_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Detail Barang (readonly) --}}
        <div class="form-group">
            <label>Jenis</label>
            <input type="text" class="form-control-plaintext" readonly value="{{ optional($barangMasuk->barang->jenis)->nama_jenis ?? 'N/A' }}">
        </div>
        <div class="form-group">
            <label>Seri</label>
            <input type="text" class="form-control-plaintext" readonly value="{{ $barangMasuk->barang->seri_barang ?? 'N/A' }}">
        </div>
        <div class="form-group">
            <label>Satuan</label>
            <input type="text" class="form-control-plaintext" readonly value="{{ optional($barangMasuk->barang->satuan)->satuan ?? 'N/A' }}">
        </div>
        <div class="form-group">
            <label>Lokasi</label>
            <input type="text" class="form-control-plaintext" readonly value="{{ optional($barangMasuk->barang->lokasi)->lokasi ?? 'N/A' }}">
        </div>

        {{-- QR Code --}}
        <div class="form-group qr-preview">
            @php
                $qrFile = storage_path('app/public/qrcode/qrcode_barang_masuk_' . $barangMasuk->id . '.svg');
                $qrExists = file_exists($qrFile);
                $qrUrl = asset('storage/qrcode/qrcode_barang_masuk_' . $barangMasuk->id . '.svg');
            @endphp
            @if($qrExists)
                <img src="{{ $qrUrl }}" alt="QR Code">
            @else
                <p>QR Code tidak tersedia</p>
            @endif
        </div>

        {{-- Lampiran --}}
        <div class="form-group">
            <label for="lampiran">Lampiran</label>
            @if($barangMasuk->lampiran)
                <p>File saat ini: <a href="{{ asset('storage/lampiran_barang_masuk/' . $barangMasuk->lampiran) }}" target="_blank">{{ $barangMasuk->lampiran }}</a></p>
            @endif
            <input type="file" id="lampiran" name="lampiran" accept=".jpg,.jpeg,.png,.pdf">
            <small>Biarkan kosong jika tidak ingin mengubah lampiran.</small>
            @error('lampiran')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tombol simpan dan batal --}}
        <div class="button-group">
            <button type="submit" class="btn-simpan">Update</button>
            <a href="{{ route('barang-masuk.index') }}" class="btn-batal">Batal</a>
        </div>
    </form>
</div>

@endsection
