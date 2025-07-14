@extends('layouts.app-admin')

@section('title', 'Data Jenis Barang')

@push('styles')
<style>
    .btn-tambah {
        background-color: #388E3C;
        color: white;
        font-weight: bold;
        padding: 8px 16px;
        border-radius: 5px;
        text-decoration: none;
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
    }

    th {
        background-color: #388E3C;
        color: white;
        text-align: center;
    }

    td.actions {
        text-align: center;
        vertical-align: middle;
    }

    .btn-edit, .btn-hapus {
        padding: 5px 10px;
        border-radius: 4px;
        border: none;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        color: white;
        text-decoration: none;
        margin: 2px;
        display: inline-block;
    }

    .btn-edit {
        background-color: #1976D2;
    }

    .btn-edit:hover {
        background-color: #1565C0;
    }

    .btn-hapus {
        background-color: #D32F2F;
    }

    .btn-hapus:hover {
        background-color: #B71C1C;
    }

    /* Modal */
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
        width: 400px;
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

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .modal-buttons {
        text-align: right;
        margin-top: 20px;
    }
</style>
@endpush

@section('content')
<h2>Data Jenis Barang</h2>

<!-- Tombol Tambah -->
<button class="btn-tambah" onclick="openModal()">+ Tambah Data</button>

<!-- Tabel -->
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Jenis</th>
            <th>Keterangan</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($jenisBarang as $index => $jenis)
        <tr>
            <td style="text-align:center;">{{ $index + 1 }}</td>
            <td>{{ $jenis->nama_jenis }}</td>
            <td>{{ $jenis->keterangan }}</td>
            <td class="actions">
                <a href="{{ route('jenis.edit', $jenis->id) }}" class="btn-edit">Edit</a>
                <form action="{{ route('jenis.destroy', $jenis->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-hapus" onclick="return confirm('Yakin hapus data ini?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal Tambah -->
<div id="tambahModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h3>Tambah Jenis</h3>
        <form action="{{ route('jenis.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama_jenis">Jenis *</label>
                <input type="text" id="nama_jenis" name="nama_jenis" required>
            </div>
            <div class="form-group">
                <label for="keterangan">Keterangan *</label>
                <textarea id="keterangan" name="keterangan" required></textarea>
            </div>
            <div class="modal-buttons">
                <button type="submit" class="btn-tambah">Simpan</button>
                <button type="button" class="btn-hapus" onclick="closeModal()">Tutup</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openModal() {
        document.getElementById('tambahModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('tambahModal').style.display = 'none';
    }

    window.onclick = function(event) {
        const modal = document.getElementById('tambahModal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
</script>
@endpush
