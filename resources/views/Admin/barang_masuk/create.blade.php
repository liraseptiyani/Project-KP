@php use Illuminate\Support\Facades\Storage; @endphp
@extends('layouts.app-admin')

@section('title', 'Form Barang Masuk')

@push('styles')
<style>
.container {
    max-width: 600px;
    margin: 60px auto;
    background-color: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

h2 {
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

input[type="text"],
input[type="number"],
input[type="date"],
input[type="file"],
select {
    width: 100%;
    padding: 8px 10px;
    font-size: 14px;
    box-sizing: border-box;
    border-radius: 5px;
    border: 1px solid #ccc;
}

input[readonly] {
    background-color: #f8f9fa;
    border: none;
    padding-left: 0;
}

.qr-image {
    display: block;
    margin-top: 10px;
    width: 150px;
    height: 150px;
    object-fit: contain;
    border: 1px solid #ddd;
    border-radius: 6px;
}

/* Tombol seperti Barang Keluar */
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
<div class="container">
    <h2>Form Barang Masuk</h2>

    <form action="{{ route('barang-masuk.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="jenis_id">Pilih Jenis</label>
            <select name="jenis_id" id="jenis_id" required>
                <option value="">-- Pilih Jenis --</option>
                @foreach($jenisList as $jenis)
                    <option value="{{ $jenis->id }}">{{ $jenis->nama_jenis }}</option>
                @endforeach
            </select>
            @error('jenis_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="barang_id">Seri Barang</label>
            <select id="barang_id" name="barang_id" required>
                <option value="">-- Pilih Seri --</option>
            </select>
            @error('barang_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="satuan">Satuan</label>
            <input type="text" id="satuan" readonly>
        </div>

        <div class="form-group">
            <label for="lokasi">Lokasi</label>
            <input type="text" id="lokasi" readonly>
        </div>

        <div class="form-group">
            <label>QR Code</label><br>
            <img id="qr_code_preview" src="" alt="QR Code" class="qr-image" style="display:none;">
        </div>

        <div class="form-group">
            <label for="jumlah">Jumlah</label>
            <input type="number" name="jumlah" id="jumlah" required value="{{ old('jumlah', 1) }}">
            @error('jumlah')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="tanggal_masuk">Tanggal Masuk</label>
            <input type="date" name="tanggal_masuk" id="tanggal_masuk" required value="{{ old('tanggal_masuk') }}">
            @error('tanggal_masuk')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="lampiran">Lampiran (Invoice/Dokumen):</label>
            <input type="file" name="lampiran" id="lampiran" accept=".jpg,.jpeg,.png,.pdf">
            @error('lampiran')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="button-group">
            <button type="submit" class="btn-simpan">Simpan</button>
            <a href="{{ route('barang-masuk.index') }}" class="btn-batal">Tutup</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const jenisSelect = document.getElementById('jenis_id');
    const barangSelect = document.getElementById('barang_id');
    const satuanInput = document.getElementById('satuan');
    const lokasiInput = document.getElementById('lokasi');
    const qrImage = document.getElementById('qr_code_preview');

    jenisSelect.addEventListener('change', function () {
        const jenisId = this.value;

        barangSelect.innerHTML = '<option value="">-- Pilih Seri --</option>';
        satuanInput.value = '';
        lokasiInput.value = '';
        qrImage.style.display = 'none';

        if (jenisId) {
            fetch(`/get-barang-by-jenis/${jenisId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(barang => {
                        const option = document.createElement('option');
                        option.value = barang.id;
                        option.textContent = barang.seri_barang;
                        barangSelect.appendChild(option);
                    });
                });
        }
    });

    barangSelect.addEventListener('change', function () {
        const barangId = this.value;

        if (barangId) {
            fetch(`/get-barang-detail/${barangId}`)
                .then(response => response.json())
                .then(data => {
                    satuanInput.value = data.satuan;
                    lokasiInput.value = data.lokasi;
                    if (data.qrcode) {
                        qrImage.src = `/storage/qr/${data.qrcode}`;
                        qrImage.style.display = 'block';
                    } else {
                        qrImage.style.display = 'none';
                    }
                });
        } else {
            satuanInput.value = '';
            lokasiInput.value = '';
            qrImage.style.display = 'none';
        }
    });
});
</script>
@endpush
