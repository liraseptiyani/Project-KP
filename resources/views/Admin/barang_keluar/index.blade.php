@extends('layouts.app-admin')

@section('title', 'Barang Keluar')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
    .btn-tambah {
        background-color: #388E3C;
        color: white;
        font-weight: bold;
        padding: 8px 14px;
        border-radius: 5px;
        text-decoration: none;
        border: none;
        font-size: 14px;
        cursor: pointer;
    }

    .btn-tambah:hover {
        background-color: #2e7d32;
    }

    .btn-export {
        background-color: #D32F2F;
        color: white;
        font-weight: bold;
        padding: 8px 14px;
        border-radius: 5px;
        border: none;
        font-size: 14px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    .btn-export:hover {
        background-color: #B71C1C;
    }

    .btn-export i {
        margin-right: 6px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background-color: white;
    }

    th, td {
        padding: 10px;
        border: 1px solid #ddd;
        font-size: 14px;
        text-align: center;
    }

    th {
        background-color: #388E3C;
        color: white;
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

    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 6px;
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
        text-align: center;
    }

    .modal-content h3 {
        margin-top: 0;
        color: #388E3C;
        margin-bottom: 20px;
    }

    .modal-buttons {
        display: flex;
        justify-content: center;
        gap: 12px;
    }

    .modal-buttons .btn {
        width: 100px;
        padding: 8px 12px;
        font-weight: bold;
        border: none;
        border-radius: 5px;
        color: white;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-success {
        background-color: #388E3C;
    }

    .btn-danger {
        background-color: #D32F2F;
    }

    .btn-success:hover {
        background-color: #2e7d32;
    }

    .btn-danger:hover {
        background-color: #b71c1c;
    }
</style>
@endpush

@section('content')
<h2>Data Barang Keluar</h2>

<div style="display: flex; justify-content: flex-end; gap: 10px; margin-bottom: 15px;">
    <a href="{{ route('barang-keluar.export.pdf') }}" class="btn-export">
        <i class="bi bi-file-earmark-pdf"></i> Export PDF
    </a>
    <a href="{{ route('barang-keluar.create') }}" class="btn-tambah">
        + Tambah Barang Keluar
    </a>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Seri Barang</th>
            <th>Jenis</th>
            <th>Satuan</th>
            <th>Lokasi</th>
            <th>Nama Peminjam</th>
            <th>Tanggal Pengembalian</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($barangKeluarList as $index => $barang)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $barang->barang->seri_barang ?? '-' }}</td>
            <td>{{ $barang->barang->jenis->nama_jenis ?? '-' }}</td>
            <td>{{ $barang->barang->satuan->satuan ?? '-' }}</td>
            <td>{{ $barang->barang->lokasi->lokasi ?? '-' }}</td>
            <td>{{ $barang->nama_peminjam }}</td>
            <td>{{ $barang->tanggal_pengembalian }}</td>
            <td>{{ ucfirst($barang->status) }}</td>
            <td class="actions">
                <div class="action-buttons">
                    <a href="{{ route('barang-keluar.edit', $barang->id) }}" class="btn-edit" title="Edit">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <button class="btn-hapus" onclick="showDeleteModal({{ $barang->id }})" title="Hapus">
                        <i class="bi bi-trash"></i>
                    </button>
                    <form id="delete-form-{{ $barang->id }}" action="{{ route('barang-keluar.destroy', $barang->id) }}" method="POST" style="display:none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal Hapus -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <h3>Apakah Anda yakin ingin menghapus data ini?</h3>
        <div class="modal-buttons">
            <button class="btn btn-success" onclick="confirmDelete()">Ya</button>
            <button class="btn btn-danger" onclick="closeDeleteModal()">Tidak</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let deleteId = null;

    function showDeleteModal(id) {
        deleteId = id;
        document.getElementById('deleteModal').style.display = 'block';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
        deleteId = null;
    }

    function confirmDelete() {
        if (deleteId !== null) {
            document.getElementById('delete-form-' + deleteId).submit();
        }
    }

    window.onclick = function(event) {
        const modal = document.getElementById('deleteModal');
        if (event.target === modal) {
            closeDeleteModal();
        }
    }
</script>
@endpush
