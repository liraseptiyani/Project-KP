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
    }

    table {
        width: 100%;
        background-color: white;
        border-collapse: collapse;
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
        margin: 2px;
    }

    .btn-edit {
        background-color: #1976D2;
    }

    .btn-hapus {
        background-color: #D32F2F;
    }

    .btn-edit:hover {
        background-color: #1565C0;
    }

    .btn-hapus:hover {
        background-color: #B71C1C;
    }

    /* Modal Hapus */
    .modal {
        display: none;
        position: fixed;
        z-index: 2000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
    }

    .modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 30px;
        border-radius: 10px;
        width: 400px;
        text-align: center;
    }

    .modal-content h3 {
        margin-bottom: 25px;
        font-size: 18px;
        color: #333;
    }

    .modal-buttons {
        display: flex;
        justify-content: center;
        gap: 20px;
    }

    .modal-buttons button {
        width: 80px;
        padding: 8px 0;
        font-weight: bold;
        border-radius: 5px;
        border: none;
        cursor: pointer;
    }

    .btn-yes {
        background-color: #388E3C;
        color: white;
    }

    .btn-no {
        background-color: #ccc;
        color: #333;
    }
</style>
@endpush

@section('content')
<h2>Data Barang</h2>

<a href="{{ route('barang.create') }}" class="btn-tambah">+ Tambah Data</a>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Barang</th>
            <th>Seri Barang</th>
            <th>Jenis</th>
            <th>Satuan</th>
            <th>Lokasi</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($barangList as $index => $barang)
        <tr>
            <td style="text-align:center;">{{ $index + 1 }}</td>
            <td>{{ $barang->kode_barang }}</td>
            <td>{{ $barang->seri_barang }}</td>
            <td>{{ $barang->jenis->nama_jenis ?? '-' }}</td>
            <td>{{ $barang->satuan->satuan ?? '-' }}</td>
            <td>{{ $barang->lokasi->lokasi ?? '-' }}</td>
            <td class="actions">
                <form action="{{ route('barang.edit', $barang->id) }}" method="GET" style="display:inline;">
                    <button type="submit" class="btn-edit">Edit</button>
                </form>
                <button type="button" class="btn-hapus" onclick="showConfirmModal({{ $barang->id }})">Hapus</button>

                <form id="delete-form-{{ $barang->id }}" action="{{ route('barang.destroy', $barang->id) }}" method="POST" style="display:none;">
                    @csrf
                    @method('DELETE')
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal Hapus -->
<div id="confirmDeleteModal" class="modal">
    <div class="modal-content">
        <h3>Apakah Anda yakin ingin menghapus data ini?</h3>
        <div class="modal-buttons">
            <button class="btn-yes" onclick="confirmDelete()">Yes</button>
            <button class="btn-no" onclick="closeConfirmModal()">No</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let deleteId = null;

    function showConfirmModal(id) {
        deleteId = id;
        document.getElementById('confirmDeleteModal').style.display = 'block';
    }

    function closeConfirmModal() {
        document.getElementById('confirmDeleteModal').style.display = 'none';
        deleteId = null;
    }

    function confirmDelete() {
        if (deleteId) {
            document.getElementById('delete-form-' + deleteId).submit();
        }
    }

    // Tutup modal jika klik di luar kotak
    window.onclick = function(event) {
        const modal = document.getElementById('confirmDeleteModal');
        if (event.target === modal) {
            closeConfirmModal();
        }
    }
</script>
@endpush
