@extends('layouts.app-admin')

@section('title', 'Tambah Barang Keluar')

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
    <h3>Tambah Barang Keluar</h3>

    <form action="{{ route('barang-keluar.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Scan QR Barang</label>
            <div id="reader" style="width: 300px;"></div>
        </div>

        <input type="hidden" name="barang_id" id="barang_id" required>

        <div class="form-group">
            <label>Seri Barang</label>
            <input type="text" id="seri_barang" name="seri_barang" readonly required>
        </div>

        <div class="form-group">
            <label>Jenis</label>
            <input type="text" id="jenis" name="jenis" readonly>
        </div>

        <div class="form-group">
            <label>Satuan</label>
            <input type="text" id="satuan" name="satuan" readonly>
        </div>

        <div class="form-group">
            <label>Lokasi</label>
            <input type="text" id="lokasi" name="lokasi" readonly>
        </div>

        <div class="form-group">
            <label>Nama Peminjam</label>
            <input type="text" name="nama_peminjam" required>
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="status" required>
                <option value="">-- Pilih Status --</option>
                <option value="dipinjam">Dipinjam</option>
                <option value="keluar">Keluar</option>
                <option value="dikembalikan">Dikembalikan</option>
            </select>
        </div>

        <div class="form-group">
            <label>Tanggal Pengembalian</label>
            <input type="date" name="tanggal_pengembalian" required>
        </div>

        <div class="button-group">
            <button type="submit" class="btn-simpan">Simpan</button>
            <a href="{{ route('barang-keluar.index') }}" class="btn-batal">Batal</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
function onScanSuccess(decodedText) {
    try {
        const data = JSON.parse(decodedText); // Format QR dalam JSON

        document.getElementById('barang_id').value = data.id || '';
        document.getElementById('seri_barang').value = data.seri_barang || '';
        document.getElementById('jenis').value = data.jenis || '';
        document.getElementById('satuan').value = data.satuan || '';
        document.getElementById('lokasi').value = data.lokasi || '';

        html5QrcodeScanner.clear(); // Stop scanning
    } catch (error) {
        alert('QR Code tidak valid. Format harus JSON dengan field: id, seri_barang, jenis, satuan, lokasi');
        console.error(error);
    }
}

const html5QrcodeScanner = new Html5QrcodeScanner("reader", {
    fps: 10,
    qrbox: 250
});
html5QrcodeScanner.render(onScanSuccess);
</script>
@endpush
