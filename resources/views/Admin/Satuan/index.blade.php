@extends('layouts.app-admin')

@section('title', 'Data Satuan Barang')

@push('styles')
<!-- CDN Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
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
        width: 36px;
        height: 36px;
        border-radius: 6px;
        border: none;
        font-size: 18px;
        cursor: pointer;
        color: white;
        margin: 2px;
        transition: background-color 0.3s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        text-decoration: none;
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
</style>
@endpush

@section('content')
<h2>Data Satuan</h2>

<!-- Tombol Tambah -->
<button class="btn-tambah" onclick="openModal()">+ Tambah Data</button>

<!-- Tabel -->
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Satuan</th>
            <th>Keterangan</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($satuanBarang as $index => $satuan)
        <tr>
            <td style="text-align:center;">{{ $index + 1 }}</td>
            <td>{{ $satuan->satuan }}</td>
            <td>{{ $satuan->keterangan }}</td>
            <td class="actions">
                <a href="{{ route('satuan.edit', $satuan->id) }}" class="btn-edit" title="Edit">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <form action="{{ route('satuan.destroy', $satuan->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn-hapus" onclick="confirmDelete({{ $satuan->id }})" title="Hapus">
                        <i class="bi bi-trash"></i>
                    </button>
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
        <h3>Tambah Satuan</h3>
        <form action="{{ route('satuan.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="satuan">Satuan *</label>
                <input type="text" id="satuan" name="satuan" required>
            </div>
            <div class="form-group">
                <label for="keterangan">Keterangan *</label>
                <textarea id="keterangan" name="keterangan" required></textarea>
            </div>
            <div class="modal-buttons">
                <button type="submit" class="btn btn-success">Simpan</button>
                <button type="button" class="btn btn-danger" onclick="closeModal()">Tutup</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Hapus -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <h3>Apakah anda yakin ingin menghapus data ini?</h3>
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-buttons">
                <button type="submit" class="btn btn-success">Ya</button>
                <button type="button" class="btn btn-danger" onclick="closeDeleteModal()">Tidak</button>
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

        function confirmDelete(id) {
        const form = document.getElementById('deleteForm');
        form.action = `/satuan/${id}`;
        document.getElementById('deleteModal').style.display = 'block';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }

    window.onclick = function(event) {
        const modal = document.getElementById('tambahModal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
</script>
@endpush
