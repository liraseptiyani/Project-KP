@extends('layouts.app-admin')

@section('content')
<div class="container">
    <h3 class="mb-4">Tambah Satuan</h3>

    <form action="{{ route('satuan.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="satuan" class="form-label">Lokasi</label>
            <input type="text" name="satuan" class="form-control" required>
        </div>

        <div class="d-flex gap-2">
            <button type="button"
                    onclick="window.location='{{ route('satuan.index') }}'"
                    class="btn btn-danger"
                    style="width: 120px;">
                Tutup
            </button>

            <button type="submit"
                    class="btn btn-success"
                    style="width: 120px;">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
