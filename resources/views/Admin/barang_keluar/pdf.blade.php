<!DOCTYPE html>
<html>
<head>
    <title>Laporan Barang Keluar</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        h2 { text-align: center; margin-bottom: 0; }
    </style>
</head>
<body>
    <h2>Laporan Barang Keluar</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Seri Barang</th>
                <th>Jenis</th>
                <th>Satuan</th>
                <th>Lokasi</th>
                <th>Peminjam</th>
                <th>Status</th>
                <th>Tanggal Pengembalian</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barangKeluarList as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->barang->seri_barang ?? '-' }}</td>
                    <td>{{ $item->barang->jenis->nama_jenis ?? '-' }}</td>
                    <td>{{ $item->barang->satuan->satuan ?? '-' }}</td>
                    <td>{{ $item->barang->lokasi->lokasi ?? '-' }}</td>
                    <td>{{ $item->nama_peminjam ?? '-' }}</td>
                    <td>{{ ucfirst($item->status) ?? '-' }}</td>
                    <td>{{ $item->tanggal_pengembalian ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>