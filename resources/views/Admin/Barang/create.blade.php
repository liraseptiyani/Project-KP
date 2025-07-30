@extends('layouts.app-admin')

@section('title', 'Tambah Barang')

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

    .button-group {
        display: flex;
        gap: 10px;
        justify-content: center;
        margin-top: 15px;
    }

    .btn-simpan, .btn-batal {
        width: 120px;
        padding: 8px;
        border-radius: 5px;
        font-weight: bold;
        font-size: 14px;
        text-align: center;
        border: none;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .btn-simpan {
        background-color: #388E3C;
        color: white;
    }

    .btn-simpan:hover {
        background-color: #2e7d32;
    }

    .btn-batal {
        background-color: #D32F2F;
        color: white;
        text-decoration: none;
        display: inline-block;
    }

    .btn-batal:hover {
        background-color: #c62828;
    }
</style>
@endpush

@section('content')
<div class="form-container">
    <h3>Tambah Barang</h3>
    <form action="{{ route('barang.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Jenis</label>
            <select name="jenis_id" id="jenis_id" required onchange="generateSeri()">
                <option value="">-- Pilih Jenis --</option>
                @foreach ($jenisList as $jenis)
                    <option value="{{ $jenis->id }}" data-prefix="{{ $jenis->prefix }}">
                        {{ $jenis->nama_jenis }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Seri Barang</label>
            <input type="text" name="seri_barang" id="seri_barang" value="{{ old('seri_barang') }}" readonly required>
        </div>

        <div class="form-group">
            <label>Satuan</label>
            <select name="satuan_id" required>
                <option value="">-- Pilih Satuan --</option>
                @foreach ($satuanList as $satuan)
                    <option value="{{ $satuan->id }}">{{ $satuan->satuan }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Lokasi</label>
            <select name="lokasi_id" required>
                <option value="">-- Pilih Lokasi --</option>
                @foreach ($lokasiList as $lokasi)
                    <option value="{{ $lokasi->id }}">{{ $lokasi->lokasi }}</option>
                @endforeach
            </select>
        </div>

        <div class="button-group">
            <button type="submit" class="btn-simpan">Simpan</button>
            <a href="{{ route('barang.index') }}" class="btn-batal">Batal</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function generateSeri() {
        const jenisSelect = document.getElementById('jenis_id');
        const selectedOption = jenisSelect.options[jenisSelect.selectedIndex];
        const prefix = selectedOption.getAttribute('data-prefix');

        if (!prefix) return;

        fetch(`/barang/generate-seri/${prefix}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('seri_barang').value = data.seri_barang;
            })
            .catch(error => {
                console.error('Gagal mengambil seri barang:', error);
            });
    }
</script>
@endpush
