@extends('layouts.app-admin')

@section('title', 'Data Barang')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
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
<h2>Data Barang</h2>

<button class="btn-tambah" onclick="window.location.href='{{ route('barang.create') }}'">+ Tambah Barang</button>

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
            <td class="actions">
                <a href="{{ route('barang.edit', $barang->id) }}" class="btn-edit" title="Edit">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <button type="button" class="btn-hapus" onclick="showDeleteModal({{ $barang->id }})" title="Hapus">
                    <i class="bi bi-trash"></i>
                </button>
                <form id="delete-form-{{ $barang->id }}" action="{{ route('barang.destroy', $barang->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal Konfirmasi Hapus -->
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

    window.onclick = function(event) {
        const modal = document.getElementById('deleteConfirmModal');
        if (event.target === modal) {
            closeDeleteModal();
        }
    }
</script>
@endpush
