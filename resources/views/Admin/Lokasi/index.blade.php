@extends('layouts.app-admin')

@section('title', 'Data Lokasi')

@push('styles')
<!-- Bootstrap Icons CDN -->
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

    /* Modal Tambah */
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
</style>
@endpush

@section('content')
<h2>Data Lokasi</h2>

<!-- Tombol Tambah -->
<button class="btn-tambah" onclick="openModal()">+ Tambah Data</button>

<!-- Tabel -->
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Lokasi</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($lokasiBarang as $index => $lokasi)
        <tr>
            <td style="text-align:center;">{{ $index + 1 }}</td>
            <td>{{ $lokasi->lokasi }}</td>
            <td class="actions">
                <a href="{{ route('lokasi.edit', $lokasi->id) }}" class="btn-edit" title="Edit">
                    <i class="bi bi-pencil-square"></i>
                </a>

                <button type="button" class="btn-hapus" onclick="showDeleteModal({{ $lokasi->id }})" title="Hapus">
                    <i class="bi bi-trash"></i>
                </button>

                <form id="delete-form-{{ $lokasi->id }}" action="{{ route('lokasi.destroy', $lokasi->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
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
        <h3>Tambah Lokasi</h3>
        <form action="{{ route('lokasi.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="lokasi">Lokasi *</label>
                <input type="text" id="lokasi" name="lokasi" required>
            </div>
            <div class="modal-buttons">
                <button type="submit" class="btn btn-success">Simpan</button>
                <button type="button" class="btn btn-danger" onclick="closeModal()">Tutup</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Hapus -->
<div id="deleteConfirmModal" class="modal">
    <div class="modal-content">
        <h3>Apakah Anda yakin ingin menghapus data ini?</h3>
        <div class="modal-buttons">
            <button class="btn btn-success" onclick="confirmDelete()">Yes</button>
            <button class="btn btn-danger" onclick="closeDeleteModal()">No</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Tambah Modal
    function openModal() {
        document.getElementById('tambahModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('tambahModal').style.display = 'none';
    }

    window.onclick = function(event) {
        const tambahModal = document.getElementById('tambahModal');
        const deleteModal = document.getElementById('deleteConfirmModal');

        if (event.target === tambahModal) {
            tambahModal.style.display = 'none';
        }

        if (event.target === deleteModal) {
            deleteModal.style.display = 'none';
        }
    }

    // Delete Modal
    let deleteId = null;

    function showDeleteModal(id) {
        deleteId = id;
        document.getElementById('deleteConfirmModal').style.display = 'block';
    }

    function closeDeleteModal() {
        document.getElementById('deleteConfirmModal').style.display = 'none';
        deleteId = null;
    }

    function confirmDelete() {
        if (deleteId !== null) {
            document.getElementById('delete-form-' + deleteId).submit();
        }
    }
</script>
@endpush
