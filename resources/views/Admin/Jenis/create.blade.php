@extends('layouts.app-admin')

@section('content')
<div class="container">
    <h3 class="mb-4">Tambah Jenis Barang</h3>

    <form action="{{ route('jenis.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama_jenis" class="form-label">Jenis</label>
            <input type="text" name="nama_jenis" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="3" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('jenis.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
