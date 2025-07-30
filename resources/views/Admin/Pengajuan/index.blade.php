@extends('layouts.app-admin')

@section('title', 'Daftar Pengajuan Barang')

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
        vertical-align: middle;
    }

    th {
        background-color: #388E3C;
        color: white;
    }

    .status-badge {
        display: inline-block;
        width: 100px;
        text-align: center;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: bold;
        color: white;
    }

    .bg-menunggu {
        background-color: #F4CE14;
    }

    .bg-disetujui {
        background-color: #4CAF50;
    }

    .bg-ditolak {
        background-color: #F44336;
    }



    .catatan-input {
        padding: 6px 8px;
        margin: 5px 0;
        border-radius: 4px;
        border: 1px solid #ccc;
        width: 100%;
    }

    .status-buttons button {
        padding: 8px 16px;
        border: none;
        border-radius: 5px;
        color: white;
        font-weight: bold;
        cursor: pointer;
        margin-right: 10px;
    }
    .status-buttons {
        display: flex;
        gap: 10px;
        margin-top: 15px;
    }

    .status-buttons button {
        flex: 1; /* Membagi rata lebar: 50% - 50% */
        padding: 12px;
        border: none;
        border-radius: 5px;
        color: white;
        font-weight: bold;
        cursor: pointer;
        font-size: 16px;
    }

    .status-buttons button:nth-child(1) {
        background-color: #388E3C; /* Hijau */
    }

    .status-buttons button:nth-child(2) {
        background-color: #D32F2F; /* Merah */
    }

    .status-buttons button:hover {
        opacity: 0.9;
    }

    .btn-verifikasi {
        background-color: #1976D2;
        color: white;
        padding: 8px 12px;
        border: none;
        border-radius: 5px;
        font-weight: bold;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 14px;
    }

    .btn-verifikasi:hover {
        background-color: #1565c0;
    }

    .btn-lihat-detail {
        background-color: #1976D2;
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 5px;
        font-weight: bold;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 14px;
    }


    .btn-lihat-detail:hover {
        background-color: #1565c0;
    }

    .close {
    position: absolute;
    top: 15px;
    right: 20px;
    color: #aaa;
    font-size: 24px;
    font-weight: bold;
    cursor: pointer;
    transition: color 0.3s ease;
    }

    .close:hover {
        color: #000;
    }


    .modal {
        display: none;
        position: fixed;
        z-index: 1050;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        background-color: white;
        margin: 5% auto;
        padding: 25px 30px;
        border-radius: 10px;
        width: 500px;
        position: relative;
        box-shadow: 0 5px 20px rgba(0,0,0,0.3);
        animation: fadeIn 0.3s ease-in-out;
    }

    .button-group {
        display: flex;
        justify-content: space-between;
        margin: 10px 0 15px 0;
    }
    .btn-green {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 10px 16px;
        cursor: pointer;
        border-radius: 5px;
        width: 48%;
    }
    .btn-red {
        background-color: #f44336;
        color: white;
        border: none;
        padding: 10px 16px;
        cursor: pointer;
        border-radius: 5px;
        width: 48%;
    }
    .btn-green:hover,
    .btn-red:hover {
        opacity: 0.9;
    }

    textarea {
        width: 100%;
        padding: 8px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .form-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }
    .btn-submit {
        background-color: #1976d2;
        color: white;
        border: none;
        padding: 10px 16px;
        border-radius: 5px;
        cursor: pointer;
    }
    .btn-cancel {
        background-color: #777;
        color: white;
        border: none;
        padding: 10px 16px;
        border-radius: 5px;
        cursor: pointer;
    }
    .btn-submit:hover,
    .btn-cancel:hover {
        opacity: 0.9;
    }
</style>
@endpush

@section('content')
<h2>Daftar Pengajuan Barang</h2>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>ID Peminjaman</th>
            <th>Tanggal Peminjaman</th>
            <th>Tanggal Pengembalin</th>
            <th>Nama</th>
            <th>Divisi</th>
            <th>Barang</th>
            <th>Jumlah</th>
            <th>Status</th>
            <th>Catatan</th>
            <th>Verifikasi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pengajuan as $p)
            <tr>
                <td>{{ $pengajuan->count() - $loop->index }}</td>
                <td>{{ $p->id_peminjaman }}</td>
                <td>{{ \Carbon\Carbon::parse($p->tanggal_peminjaman)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($p->tanggal_pengembalian)->format('d/m/Y') }}</td>
                <td>{{ $p->nama_peminjam }}</td>
                <td>{{ $p->divisi }}</td>
                <td>{{ $p->nama_barang }}</td>
                <td>{{ $p->jumlah_barang }}</td>
                @if (strtolower($p->status) === 'menunggu')
                    <td><span class="status-badge bg-menunggu">Menunggu</span></td>
                    <td>-</td>
                    <td>
                        <div style="display: flex; gap: 5px;">
                            <button class="btn-verifikasi" onclick='openVerifikasiModal(@json($p))'
                                style="min-width: 120px; white-space: nowrap; text-align: center;">
                                <i class="fas fa-check"> </i> Verifikasi
                            </button>
                        </div>
                    </td>
                @else
                    @php
                        $statusClass = strtolower($p->status) === 'disetujui' ? 'bg-disetujui' :
                                    (strtolower($p->status) === 'ditolak' ? 'bg-ditolak' : 'bg-menunggu');
                    @endphp
                    <td><span class="status-badge {{ $statusClass }}">{{ ucfirst($p->status) }}</span></td>
                    <td>{{ $p->catatan ?? '-' }}</td>
                    <td>
                        <div style="display: flex; gap: 5px;">
                            <button class="btn-lihat-detail" onclick='lihatDetail(@json($p))'
                                style="min-width: 120px; white-space: nowrap; text-align: center;">
                                <i class="fas fa-eye"></i>Lihat Detail
                            </button>
                        </div>
                    </td>
                @endif

            </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal Verifikasi -->
<div id="verifikasiModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeVerifikasiModal()">&times;</span>
        <h3 style="text-align: center; color: #388E3C;">Verifikasi Pengajuan</h3>

        <p><strong>ID Peminjaman:</strong> <span id="form-id-peminjaman"></span></p>
        <p><strong>Tanggal Peminjaman:</strong> <span id="form-tanggal-peminjaman"></span></p>
        <p><strong>Tanggal Pengembalian:</strong> <span id="form-tanggal-pengembalian"></span></p>
        <p><strong>Nama:</strong> <span id="form-nama"></span></p>
        <p><strong>Barang:</strong> <span id="form-barang"></span></p>
        <p><strong>Jumlah:</strong> <span id="form-jumlah"></span></p>

        <form id="verifikasiForm" action="{{ route('admin.pengajuan.verifikasi') }}" method="POST">
            @csrf
            <input type="hidden" name="id" id="form-id">
            <input type="hidden" name="status" id="form-status">

            <div class="form-group">
                <label for="form-catatan"><strong>Catatan (opsional):</strong></label>
                <textarea name="catatan" id="form-catatan" rows="3"></textarea>
            </div>

            <label><strong>Status:</strong></label>
            <div class="status-buttons">
                <button type="button" onclick="submitVerifikasi('disetujui')">Disetujui</button>
                <button type="button" onclick="submitVerifikasi('ditolak')">Ditolak</button>
            </div>
        </form> <!-- INI YANG DITAMBAHKAN! -->
    </div>
</div>



<!-- Modal Detail -->
<div id="detailModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeDetailModal()">&times;</span>
        <h3 style="text-align: center; color: #388E3C;">Detail Pengajuan</h3>
        <p><strong>ID Peminjaman:</strong> <span id="detail-id"></span></p>
        <p><strong>Tanggal Peminjaman:</strong> <span id="detail-tanggal-peminjaman"></span></p>
        <p><strong>Tanggal Pengembalian:</strong> <span id="detail-tanggal-pengembalian"></span></p>
        <p><strong>Nama:</strong> <span id="detail-nama"></span></p>
        <p><strong>Barang:</strong> <span id="detail-barang"></span></p>
        <p><strong>Jumlah:</strong> <span id="detail-jumlah"></span></p>
        <p><strong>Status:</strong> <span id="detail-status"></span></p>
        <p><strong>Catatan:</strong> <span id="detail-catatan"></span></p>
        <div class="form-buttons">
            <button class="btn-cancel" onclick="closeDetailModal()">Tutup</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function formatDate(dateStr) {
        if (!dateStr) return '-';
        const date = new Date(dateStr);
       return `${date.getDate().toString().padStart(2, '0')}/${(date.getMonth() + 1).toString().padStart(2, '0')}/${date.getFullYear()}`;
    }

    function openVerifikasiModal(p) {
        document.getElementById("verifikasiModal").style.display = "block";

        document.getElementById("form-id").value = p.id;
        document.getElementById("form-status").value = p.status?.toLowerCase() || '';
        document.getElementById("form-catatan").value = p.catatan || '';

        document.getElementById("form-id-peminjaman").innerText = p.id_peminjaman || '-';
        document.getElementById("form-tanggal-peminjaman").innerText = formatDate(p.tanggal_peminjaman);
        document.getElementById("form-tanggal-pengembalian").innerText = formatDate(p.tanggal_pengembalian);
        document.getElementById("form-nama").innerText = p.nama_peminjam || '-';
        document.getElementById("form-barang").innerText = p.nama_barang || '-';
        document.getElementById("form-jumlah").innerText = p.jumlah_barang || '-';
    }
    function submitVerifikasi(status) {
        document.getElementById('form-status').value = status;
        document.getElementById('verifikasiForm').submit();
    }

    function closeVerifikasiModal() {
        document.getElementById("verifikasiModal").style.display = "none";
    }

    function lihatDetail(p) {
        document.getElementById("detailModal").style.display = "block";

        document.getElementById("detail-id").innerText = p.id_peminjaman || '-';
        document.getElementById("detail-tanggal-peminjaman").innerText = formatDate(p.tanggal_peminjaman);
        document.getElementById("detail-tanggal-pengembalian").innerText = formatDate(p.tanggal_pengembalian);
        document.getElementById("detail-nama").innerText = p.nama_peminjam || '-';
        document.getElementById("detail-barang").innerText = p.nama_barang || '-';
        document.getElementById("detail-jumlah").innerText = p.jumlah_barang || '-';
        document.getElementById("detail-status").innerText = p.status || '-';
        document.getElementById("detail-catatan").innerText = p.catatan || '-';
    }

    function closeDetailModal() {
        document.getElementById("detailModal").style.display = "none";
    }

    function setStatus(status) {
    document.getElementById('form-status').value = status;

    // Hapus kelas 'selected' dari semua button
    document.querySelectorAll('.status-buttons button').forEach(btn => btn.classList.remove('selected'));

    // Tambahkan kelas 'selected' pada button yang dipilih
    const selectedButton = document.querySelector(`.status-buttons button[onclick*="${status}"]`);
    if (selectedButton) selectedButton.classList.add('selected');
}


    window.onclick = function(event) {
        const verifModal = document.getElementById("verifikasiModal");
        const detailModal = document.getElementById("detailModal");
        if (event.target === verifModal) closeVerifikasiModal();
        if (event.target === detailModal) closeDetailModal();
    }
</script>
@endpush