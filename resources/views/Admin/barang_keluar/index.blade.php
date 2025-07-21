@extends('layouts.app-admin')

@section('title', 'Barang Keluar')

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
        width: 70px;
        padding: 5px 0;
        border-radius: 4px;
        border: none;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        color: white;
        text-decoration: none;
        margin: 2px;
        display: inline-block;
        text-align: center;
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
<h2>Data Barang Keluar</h2>

<a href="{{ route('barang-keluar.create') }}" class="btn-tambah">+ Tambah Barang Keluar</a>

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
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($barangKeluarList as $index => $barang)
        <tr>
            <td style="text-align: center;">{{ $index + 1 }}</td>
            <td>{{ $barang->barang->seri_barang ?? '-' }}</td>
            <td>{{ $barang->barang->jenis->nama_jenis ?? '-' }}</td>
            <td>{{ $barang->barang->satuan->satuan ?? '-' }}</td>
            <td>{{ $barang->barang->lokasi->lokasi ?? '-' }}</td>
            <td>{{ $barang->nama_peminjam }}</td>
            <td>{{ $barang->tanggal_pengembalian }}</td>
            <td>{{ ucfirst($barang->status) }}</td>
            <td class="actions">
    <div style="display: flex; justify-content: center; gap: 6px;">
        <form action="{{ route('barang-keluar.edit', $barang->id) }}" method="GET">
            <button type="submit" class="btn-edit">Edit</button>
        </form>
        <button type="button" class="btn-hapus" onclick="confirmDelete('{{ $barang->id }}')">Hapus</button>
    </div>
</td>

        </tr>
        @endforeach
    </tbody>
</table>

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
    function confirmDelete(id) {
        const form = document.getElementById('deleteForm');
        form.action = `/barang-keluar/${id}`;
        document.getElementById('deleteModal').style.display = 'block';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }

    window.onclick = function(event) {
        const deleteModal = document.getElementById('deleteModal');
        if (event.target == deleteModal) {
            deleteModal.style.display = 'none';
        }
    }
</script>
@endpush
