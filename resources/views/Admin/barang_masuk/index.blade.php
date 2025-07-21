@extends('layouts.app-admin')

@section('title', 'Barang Masuk')

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
        cursor: pointer;
    }

    .btn-tambah:hover {
        background-color: #2e7d32;
    }

    table {
        width: 100%;
        background-color: white;
        border-collapse: collapse;
        font-family: Arial, sans-serif;
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

    td {
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
        transition: background-color 0.3s;
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
    <h2>Data Barang Masuk</h2>

    <a href="{{ route('barang-masuk.create') }}" class="btn-tambah">+ Tambah Barang Masuk</a>

    @if(session('success'))
        <div style="background-color:#d4edda; border:1px solid #c3e6cb; padding:10px 15px; border-radius:5px; color:#155724; margin-top: 15px; margin-bottom: 20px; text-align: center;">
            {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>ID Barang Masuk</th>
                <th>Jenis</th>
                <th>Seri Barang</th>
                <th>Satuan</th>
                <th>Lokasi</th>
                <th>Tanggal Masuk</th>
                <th>QR Code</th>
                <th>Invoice</th>
                <th class="actions">Aksi</th>
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
                        @php
                            $qrPath = Storage::url('qrcode/qrcode_barang_masuk_' . $bm->id . '.svg');
                            $qrExists = Storage::disk('public')->exists('qrcode/qrcode_barang_masuk_' . $bm->id . '.svg');
                        @endphp
                        @if($qrExists)
                            <img src="{{ $qrPath }}" alt="QR Code" style="width:80px; height:80px; object-fit:contain; border:1px solid #ccc; border-radius:4px;">
                            <br>
                            <a href="{{ $qrPath }}" download style="font-size:12px; color:#388E3C;">Download</a>
                        @else
                            <span>QR Code tidak tersedia</span>
                        @endif
                    </td>

                    <td>
    @php
        $invoicePath = asset('lampiran_barang_masuk/' . $bm->lampiran);
        $invoiceExists = $bm->lampiran && file_exists(public_path('lampiran_barang_masuk/' . $bm->lampiran));
    @endphp
    @if($invoiceExists)
        @php
            $fileExtension = pathinfo($bm->lampiran, PATHINFO_EXTENSION);
        @endphp
        @if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
            <img src="{{ $invoicePath }}" alt="Invoice" style="width:80px; height:80px; object-fit:contain; border:1px solid #ccc; border-radius:4px;">
        @else
            <img src="https://placehold.co/80x80/cccccc/333333?text=PDF" alt="PDF Icon" style="width:80px; height:80px; border-radius:4px;">
        @endif
        <br>
        <a href="{{ $invoicePath }}" target="_blank" style="font-size:12px; color:#388E3C;">Lihat/Download</a>
    @else
        <span>Invoice tidak tersedia</span>
    @endif
</td>


                    <td class="actions">
                        <a href="{{ route('barang-masuk.edit', $bm->id) }}" class="btn-edit">Edit</a>
                        <form action="{{ route('barang-masuk.destroy', $bm->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin hapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-hapus">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align:center;">Belum ada data barang masuk.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Modal Hapus jika mau dipakai -->
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
