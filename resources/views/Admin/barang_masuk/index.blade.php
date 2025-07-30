@php use Illuminate\Support\Facades\Storage; @endphp
@extends('layouts.app-admin')

@section('title', 'Barang Masuk')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<style>
    .btn-tambah {
        background-color: #388E3C;
        color: white;
        font-weight: bold;
        padding: 8px 14px;
        border-radius: 5px;
        border: none;
        font-size: 14px;
        text-decoration: none;
        cursor: pointer;
        display: inline-block;
    }

    .btn-tambah:hover {
        background-color: #2e7d32;
    }

    .btn-export-pdf {
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
        transition: background-color 0.3s;
    }

    .btn-export-pdf:hover {
        background-color: #B71C1C;
    }

    .btn-export-pdf i {
        margin-right: 6px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background-color: white;
    }

    th, td {
        padding: 12px;
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

    /* Modal Hapus */
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
        padding: 20px;
        border: 1px solid #ccc;
        width: 400px;
        border-radius: 8px;
        position: relative;
        text-align: center;
    }

    .modal-content h3 {
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
<h2>Data Barang Masuk</h2>

<div style="display: flex; justify-content: flex-end; gap: 10px; margin-bottom: 15px;">
    <a href="{{ route('barang_masuk.export_pdf') }}" class="btn-export-pdf">
        <i class="bi bi-file-earmark-pdf"></i> Export PDF
    </a>
    <a href="{{ route('barang-masuk.create') }}" class="btn-tambah">+ Tambah Barang Masuk</a>
</div>

@if(session('success'))
    <div style="background-color:#d4edda; border:1px solid #c3e6cb; padding:10px 15px; border-radius:5px; color:#155724; margin-bottom: 20px; text-align: center;">
        {{ session('success') }}
    </div>
@endif

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Jenis</th>
            <th>Seri Barang</th>
            <th>Satuan</th>
            <th>Lokasi</th>
            <th>Tanggal Masuk</th>
            <th>QR Code</th>
            <th>Invoice</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($barangMasuk as $bm)
        <tr>
            <td>{{ $bm->id }}</td>
            <td>{{ $bm->barang->jenis->nama_jenis ?? '-' }}</td>
            <td>{{ $bm->barang->seri_barang ?? '-' }}</td>
            <td>{{ $bm->barang->satuan->satuan ?? '-' }}</td>
            <td>{{ $bm->barang->lokasi->lokasi ?? '-' }}</td>
            <td>{{ \Carbon\Carbon::parse($bm->tanggal_masuk)->format('d-m-Y') }}</td>
            <td>
                @if ($bm->barang && $bm->barang->qr_code && file_exists(public_path('storage/qr/' . $bm->barang->qr_code)))
                    <img src="{{ asset('storage/qr/' . $bm->barang->qr_code) }}" alt="QR Code" style="width:80px; height:80px; object-fit:contain; border:1px solid #ccc; border-radius:4px;">
                    <br>
                    <a href="{{ asset('storage/qr/' . $bm->barang->qr_code) }}" download style="font-size:12px; color:#388E3C;">Download</a>
                @else
                    <span style="font-size:13px;">QR Code tidak tersedia</span>
                @endif
            </td>
            <td>
                @php $ext = pathinfo($bm->lampiran, PATHINFO_EXTENSION); @endphp
                @if ($bm->lampiran)
                    @if(in_array(strtolower($ext), ['jpg','jpeg','png']))
                        <img src="{{ asset('storage/lampiran_barang_masuk/' . $bm->lampiran) }}" alt="Lampiran" style="width:80px; height:80px; object-fit:contain; border:1px solid #ccc; border-radius:4px;">
                        <br>
                        <a href="{{ asset('storage/lampiran_barang_masuk/' . $bm->lampiran) }}" target="_blank" style="font-size:12px; color:#388E3C;">Lihat</a>
                    @else
                        <a href="{{ asset('storage/lampiran_barang_masuk/' . $bm->lampiran) }}" target="_blank" style="font-size:13px; color:#388E3C;">Lihat Lampiran</a>
                    @endif
                @else
                    <span style="font-size:13px;">Tidak ada lampiran</span>
                @endif
            </td>
            <td class="actions">
                <div class="action-buttons">
                    <a href="{{ route('barang-masuk.edit', $bm->id) }}" class="btn-edit" title="Edit">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <button class="btn-hapus" onclick="showDeleteModal({{ $bm->id }})" title="Hapus">
                        <i class="bi bi-trash"></i>
                    </button>
                    <form id="delete-form-{{ $bm->id }}" action="{{ route('barang-masuk.destroy', $bm->id) }}" method="POST" style="display:none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="9" style="text-align:center;">Belum ada data barang masuk.</td>
        </tr>
        @endforelse
    </tbody>
</table>

<!-- Modal Hapus -->
<div id="deleteConfirmModal" class="modal">
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
