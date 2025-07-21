@extends('layouts.app-admin')

@section('title', 'Data Barang')

@push('styles')
<style>
    .btn-tambah {
        background-color: #388E3C;
        color: white;
        font-weight: bold;
        padding: 8px 16px;
        border-radius: 5px;
        border: none;
        float: right;
        margin-bottom: 15px;
        transition: background-color 0.3s;
    }

    .btn-tambah:hover {
        background-color: #2e7d32;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background-color: white;
    }

    th, td {
        padding: 12px;
        border: 1px solid #ddd;
        text-align: center;
        vertical-align: middle;
    }

    th {
        background-color: #388E3C;
        color: white;
    }

    .qr-image {
        width: 80px;
        height: 80px;
        object-fit: contain;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 2000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.5);
    }

    .modal-content {
        background-color: #fff;
        margin: 8% auto;
        padding: 20px 25px;
        border: 1px solid #ccc;
        width: 450px;
        border-radius: 8px;
        position: relative;
    }

    .modal-content h3 {
        margin-top: 0;
        color: #388E3C;
        text-align: center;
    }

    .close {
        position: absolute;
        top: 12px;
        right: 15px;
        color: #aaa;
        font-size: 20px;
        font-weight: bold;
        cursor: pointer;
    }

    .form-group label {
        display: block;
        margin-top: 10px;
        font-weight: bold;
        color: #333;
    }

    .form-group select,
    .form-group input {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .modal-buttons {
        margin-top: 20px;
        display: flex;
        justify-content: center;
        gap: 12px;
    }

    .modal-buttons .btn {
        width: 120px;
        padding: 10px;
        font-weight: bold;
        border: none;
        border-radius: 5px;
        color: white;
        cursor: pointer;
        transition: 0.2s;
        text-align: center;
    }

    .modal-buttons .btn-success {
        background-color: #388E3C;
    }

    .modal-buttons .btn-success:hover {
        background-color: #2e7d32;
    }

    .modal-buttons .btn-danger {
        background-color: #D32F2F;
    }

    .modal-buttons .btn-danger:hover {
        background-color: #B71C1C;
    }

    .btn-sm {
        padding: 6px 10px;
        font-size: 0.85rem;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        color: #fff;
        text-decoration: none;
    }

    .btn-warning {
        background-color: #FBC02D;
    }

    .btn-warning:hover {
        background-color: #F9A825;
    }

    .btn-danger {
        background-color: #D32F2F;
    }

    .btn-danger:hover {
        background-color: #B71C1C;
    }
</style>
@endpush

@section('content')
<h2>Data Barang</h2>

<button class="btn-tambah" onclick="openModal()">+ Tambah Barang</button>

@if(session('success'))
    <div class="alert alert-success mt-2">{{ session('success') }}</div>
@endif

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Seri Barang</th>
            <th>Jenis</th>
            <th>Satuan</th>
            <th>Lokasi</th>
            <th>QR Code</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($barangList as $index => $barang)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $barang->seri_barang }}</td>
            <td>{{ $barang->jenis->nama_jenis ?? '-' }}</td>
            <td>{{ $barang->satuan->satuan ?? '-' }}</td>
            <td>{{ $barang->lokasi->lokasi ?? '-' }}</td>
            <td>
                @if($barang->qr_code)
                    <img src="{{ asset('storage/qr/' . $barang->qr_code) }}" class="qr-image" alt="QR">
                @else
                    <span class="text-muted">Tidak ada</span>
                @endif
            </td>
            <td>
                <div style="display: flex; justify-content: center; gap: 6px;">
                    <a href="{{ route('barang.edit', $barang->id) }}" class="btn-sm btn-warning">Edit</a>
                    <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-sm btn-danger">Hapus</button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal Tambah Barang -->
<div id="modalTambah" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h3>Tambah Barang</h3>
        <form method="POST" action="{{ route('barang.store') }}">
            @csrf

            <div class="form-group">
                <label for="jenis_id">Jenis *</label>
                <select name="jenis_id" id="jenis_id" required>
                    <option value="">-- Pilih Jenis --</option>
                    @foreach($jenisList as $jenis)
                        <option value="{{ $jenis->id }}" data-prefix="{{ $jenis->prefix }}">
                            {{ $jenis->nama_jenis }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="seri_barang">Seri Barang *</label>
                <input type="text" name="seri_barang" id="seri_barang" readonly required>
            </div>

            <div class="form-group">
                <label for="satuan_id">Satuan *</label>
                <select name="satuan_id" id="satuan_id" required>
                    <option value="">-- Pilih Satuan --</option>
                    @foreach($satuanList as $satuan)
                        <option value="{{ $satuan->id }}">{{ $satuan->satuan }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="lokasi_id">Lokasi *</label>
                <select name="lokasi_id" id="lokasi_id" required>
                    <option value="">-- Pilih Lokasi --</option>
                    @foreach($lokasiList as $lokasi)
                        <option value="{{ $lokasi->id }}">{{ $lokasi->lokasi }}</option>
                    @endforeach
                </select>
            </div>

            <div class="modal-buttons">
                <button type="submit" class="btn btn-success">Simpan</button>
                <button type="button" class="btn btn-danger" onclick="closeModal()">Tutup</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function openModal() {
        document.getElementById('modalTambah').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('modalTambah').style.display = 'none';
    }

    window.onclick = function(event) {
        const modal = document.getElementById('modalTambah');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }

    $('#jenis_id').on('change', function () {
        let selectedOption = $(this).find(':selected');
        let prefix = selectedOption.data('prefix');

        if (prefix) {
            $.ajax({
                url: '/barang/generate-seri/' + prefix,
                method: 'GET',
                success: function (res) {
                    $('#seri_barang').val(res.seri_barang);
                },
                error: function () {
                    alert('Gagal mengambil seri barang. Coba lagi.');
                }
            });
        } else {
            $('#seri_barang').val('');
        }
    });
</script>
@endpush
