<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Seluruh Barang Masuk</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
            font-size: 10pt;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 5px;
            text-align: center;
            vertical-align: middle;
        }
        th {
            background-color: #388E3C;
            color: white;
        }
        h2 {
            text-align: center;
            font-family: Arial, sans-serif;
            margin-bottom: 20px;
        }
        img.qr-invoice {
            width: 60px;
            height: 60px;
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <h2>Laporan Seluruh Barang Masuk</h2>
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
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->barang->jenis->nama_jenis ?? '-' }}</td>
                    <td>{{ $item->barang->seri_barang ?? '-' }}</td>
                    <td>{{ $item->barang->satuan->satuan ?? '-' }}</td>
                    <td>{{ $item->barang->lokasi->lokasi ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('d-m-Y') }}</td>
                     <td>
                @if ($item->barang && $item->barang->qr_code)
                    <img src="{{ public_path('storage/qr/' . $item->barang->qr_code) }}" width="80">
                @else
                    -
                @endif
            </td>
                    </td>
                    <td>
                        @php
                            $invoicePath = public_path('storage/lampiran_barang_masuk/' . $item->lampiran);
                        @endphp
                        @if($item->lampiran && file_exists($invoicePath))
                            <img class="qr-invoice" src="{{ $invoicePath }}">
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
