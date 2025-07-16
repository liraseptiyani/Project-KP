@extends('layouts.app-admin')

@section('title', 'Edit Jenis Barang')

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

    .form-group input,
    .form-group textarea {
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
    <h3>Edit Jenis Barang</h3>
    <form action="{{ route('jenis.update', $jenis->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nama_jenis">Jenis</label>
            <input type="text" name="nama_jenis" id="nama_jenis" value="{{ $jenis->nama_jenis }}" required>
        </div>

        <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <textarea name="keterangan" id="keterangan" rows="3" required>{{ $jenis->keterangan }}</textarea>
        </div>

        <button type="submit" class="btn-simpan">Simpan Perubahan</button>
        <a href="{{ route('jenis.index') }}" class="btn-batal">Batal</a>
    </form>
</div>
@endsection
