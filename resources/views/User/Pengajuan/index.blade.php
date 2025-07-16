@extends('layouts.app-user')

@section('title', 'Pengajuan Barang')

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
        text-align: center;
    }

    th {
        background-color: #388E3C;
        color: white;
    }

    .btn-edit, .btn-hapus {
        padding: 5px 10px;
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
        z-index: 9999;
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
    }

    .modal-content h3 {
        text-align: center;
        color: #388E3C;
    }

    .close {
        position: absolute;
        top: 12px;
        right: 15px;
        font-size: 20px;
        font-weight: bold;
        color: #aaa;
        cursor: pointer;
    }

    .form-group label {
        display: block;
        margin-top: 10px;
        font-weight: bold;
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
        text-align: right;
        margin-top: 20px;
    }
</style>
@endpush

@section('content')
<h2>Pengajuan Barang</h2>

<button class="btn-tambah" onclick="openModal()">+ Ajukan Barang</button>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Tgl Pinjam</th>
            <th>Tgl Kembali</th>
            <th>Nama</th>
            <th>Divisi</th>
            <th>Barang</th>
            <th>Jumlah</th>
            <th>Status</th>
            <th>Catatan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pengajuans as $p)
            <tr>
                <td>{{ $p->id_peminjaman }}</td>
                <td>{{ \Carbon\Carbon::parse($p->tanggal_peminjaman)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($p->tanggal_pengembalian)->format('d/m/Y') }}</td>
                <td>{{ $p->nama_peminjam }}</td>
                <td>{{ $p->divisi }}</td>
                <td>{{ $p->nama_barang }}</td>
                <td>{{ $p->jumlah_barang }}</td>
                <td class="status-{{ $p->status }}">{{ ucfirst($p->status) }}</td>
                <td>{{ $p->catatan ?? '-' }}</td>
                <td class="actions">
                    @if($p->status === 'menunggu')
                        <button class="btn-edit" onclick='openEditModal(@json($p))'>Edit</button>
                        <form action="{{ route('pengajuan.destroy', $p->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn-hapus" type="submit" onclick="return confirm('Yakin hapus data ini?')">Hapus</button>
                        </form>
                    @else
                        -
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal Tambah -->
<div id="pengajuanModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h3>Ajukan Peminjaman Barang</h3>
        <form action="{{ route('pengajuan.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Peminjam <span style="color:red">*</span></label>
                <input type="text" name="nama_peminjam" required>
            </div>
            <div class="form-group">
                <label>Tanggal Peminjaman <span style="color:red">*</span></label>
                <input type="date" name="tanggal_peminjaman" required>
            </div>
            <div class="form-group">
                <label>Tanggal Pengembalian <span style="color:red">*</span></label>
                <input type="date" name="tanggal_pengembalian" required>
            </div>
            <div class="form-group">
                <label>Nama Barang <span style="color:red">*</span></label>
                <input type="text" name="nama_barang" required>
            </div>
            <div class="form-group">
                <label>Jumlah Barang <span style="color:red">*</span></label>
                <input type="number" name="jumlah_barang" min="1" required>
            </div>
            <div class="modal-buttons">
                <button type="submit" class="btn-tambah">Simpan</button>
                <button type="button" class="btn-hapus" onclick="closeModal()">Tutup</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <h3>Edit Pengajuan</h3>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Nama Peminjam <span style="color:red">*</span></label>
                <input type="text" name="nama_peminjam" id="edit_nama_peminjam" required>
            </div>
            <div class="form-group">
                <label>Tanggal Peminjaman <span style="color:red">*</span></label>
                <input type="date" name="tanggal_peminjaman" id="edit_tanggal_peminjaman" required>
            </div>
            <div class="form-group">
                <label>Tanggal Pengembalian <span style="color:red">*</span></label>
                <input type="date" name="tanggal_pengembalian" id="edit_tanggal_pengembalian" required>
            </div>
            <div class="form-group">
                <label>Nama Barang <span style="color:red">*</span></label>
                <input type="text" name="nama_barang" id="edit_nama_barang" required>
            </div>
            <div class="form-group">
                <label>Jumlah Barang <span style="color:red">*</span></label>
                <input type="number" name="jumlah_barang" id="edit_jumlah_barang" required>
            </div>
            <div class="modal-buttons">
                <button type="submit" class="btn-tambah">Update</button>
                <button type="button" class="btn-hapus" onclick="closeEditModal()">Tutup</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openModal() {
        document.getElementById('pengajuanModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('pengajuanModal').style.display = 'none';
    }

    function openEditModal(data) {
        document.getElementById('editModal').style.display = 'block';
        document.getElementById('editForm').action = `/pengajuan/${data.id}`;
        document.getElementById('edit_nama_peminjam').value = data.nama_peminjam;
        document.getElementById('edit_tanggal_peminjaman').value = data.tanggal_peminjaman;
        document.getElementById('edit_tanggal_pengembalian').value = data.tanggal_pengembalian;
        document.getElementById('edit_nama_barang').value = data.nama_barang;
        document.getElementById('edit_jumlah_barang').value = data.jumlah_barang;
    }

    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == document.getElementById('pengajuanModal')) {
            closeModal();
        }
        if (event.target == document.getElementById('editModal')) {
            closeEditModal();
        }
    }
</script>
@endpush
