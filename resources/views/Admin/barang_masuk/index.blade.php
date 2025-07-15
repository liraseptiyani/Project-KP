@extends('layouts.app')

@section('title', 'Barang Masuk')

@section('content')
<div class="container mt-4">
    <h2>Form Barang Masuk</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('barang-masuk.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Tanggal Masuk --}}
        <div class="mb-3">
            <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
            <input type="date" name="tanggal_masuk" class="form-control" required>
        </div>

        {{-- Dropdown Kode Barang --}}
        <div class="mb-3">
            <label for="kode_barang" class="form-label">Kode Barang</label>
            <select name="kode_barang" id="kode_barang" class="form-select" required onchange="tampilkanDetailBarang()">
                <option value="">-- Pilih Kode Barang --</option>
                @foreach ($barang as $item)
                    <option 
                        value="{{ $item->id }}"
                        data-id="{{ $item->id }}"
                        data-jenis="{{ $item->jenis }}"
                        data-seri="{{ $item->seri }}"
                        data-satuan="{{ $item->satuan }}"
                        data-lokasi="{{ $item->lokasi }}"
                    >
                        {{ $item->kode_barang }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Tabel Detail Barang --}}
        <div id="detail_barang" class="mb-3 d-none">
            <label class="form-label">Detail Barang</label>
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <td id="val_id"></td>
                </tr>
                <tr>
                    <th>Jenis</th>
                    <td id="val_jenis"></td>
                </tr>
                <tr>
                    <th>Seri</th>
                    <td id="val_seri"></td>
                </tr>
                <tr>
                    <th>Satuan</th>
                    <td id="val_satuan"></td>
                </tr>
                <tr>
                    <th>Lokasi</th>
                    <td id="val_lokasi"></td>
                </tr>
            </table>
        </div>

        {{-- Upload File --}}
        <div class="mb-3">
            <label for="lampiran" class="form-label">Lampiran (optional)</label>
            <input type="file" name="lampiran" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

<script>
    function tampilkanDetailBarang() {
        const select = document.getElementById('kode_barang');
        const selected = select.options[select.selectedIndex];

        if (selected.value === "") {
            document.getElementById('detail_barang').classList.add('d-none');
            return;
        }

        document.getElementById('val_id').innerText = selected.getAttribute('data-id');
        document.getElementById('val_jenis').innerText = selected.getAttribute('data-jenis');
        document.getElementById('val_seri').innerText = selected.getAttribute('data-seri');
        document.getElementById('val_satuan').innerText = selected.getAttribute('data-satuan');
        document.getElementById('val_lokasi').innerText = selected.getAttribute('data-lokasi');

        document.getElementById('detail_barang').classList.remove('d-none');
    }
</script>
@endsection
