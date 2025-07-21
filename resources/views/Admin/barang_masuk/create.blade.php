@extends('layouts.app-admin')

@section('title', 'Barang Masuk')

@push('styles')
<style>
    .form-container {
        max-width: 800px;
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

    .qr-preview {
        display: flex;
        justify-content: center;
        margin-top: 15px;
    }

    .btn-primary {
        background-color: #388E3C;
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 5px;
        font-weight: bold;
        cursor: pointer;
        display: block;
        margin: 0 auto;
    }

    .btn-primary:hover {
        background-color: #2e7d32;
    }

    .alert-success {
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
        padding: 10px 15px;
        border-radius: 5px;
        color: #155724;
        margin-bottom: 20px;
        text-align: center;
    }
</style>
@endpush

@section('content')
<div class="form-container">
    <h3>Form Barang Masuk</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('barang-masuk.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="tanggal_masuk">Tanggal Masuk</label>
            <input type="date" name="tanggal_masuk" class="form-control" value="{{ old('tanggal_masuk') }}" required>
        </div>

        <div class="form-group">
            <label for="kode_barang">Kode Barang</label>
            <select name="kode_barang" id="kode_barang" class="form-select" onchange="tampilkanDetailBarang()" required>
                <option value="">-- Pilih Kode Barang --</option>
                @foreach ($barangList as $item)
                    <option 
                        value="{{ $item->id }}"
                        data-jenis="{{ $item->jenis->nama_jenis ?? '-' }}"
                        data-seri="{{ $item->seri_barang }}"
                        data-satuan="{{ $item->satuan->satuan ?? '-' }}"
                        data-lokasi="{{ $item->lokasi->lokasi ?? '-' }}"
                        data-qr="{{ asset('storage/qrcodes/' . $item->qr_code) }}"
                        {{ old('kode_barang') == $item->id ? 'selected' : '' }}
                    >
                        {{ $item->kode_barang }}
                    </option>
                @endforeach
            </select>
        </div>

        <div id="detail_barang">
            <div class="form-group">
                <label>Jenis</label>
                <input type="text" id="val_jenis" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label>Seri</label>
                <input type="text" id="val_seri" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label>Satuan</label>
                <input type="text" id="val_satuan" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label>Lokasi</label>
                <input type="text" id="val_lokasi" class="form-control" readonly>
            </div>

            <div class="form-group">
                <label>QR Code</label>
                <div class="qr-preview">
                    <img id="val_qr" src="" alt="QR Code" width="120">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="lampiran">Lampiran</label>
            <input type="file" name="lampiran" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
        </div>

        <button type="submit" class="btn-primary">Simpan</button>
    </form>
</div>

<script>
function tampilkanDetailBarang() {
    const select = document.getElementById('kode_barang');
    const selected = select.options[select.selectedIndex];

    document.getElementById('val_jenis').value  = selected.getAttribute('data-jenis') || '';
    document.getElementById('val_seri').value   = selected.getAttribute('data-seri') || '';
    document.getElementById('val_satuan').value = selected.getAttribute('data-satuan') || '';
    document.getElementById('val_lokasi').value = selected.getAttribute('data-lokasi') || '';
    document.getElementById('val_qr').src       = selected.getAttribute('data-qr') || '';
}

window.addEventListener('DOMContentLoaded', () => {
    tampilkanDetailBarang();
});
</script>
@endsection
