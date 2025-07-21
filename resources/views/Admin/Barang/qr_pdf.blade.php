<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>QR Barang</title>
</head>
<body style="text-align: center; font-family: sans-serif;">
    <h4>{{ $barang->seri_barang }}</h4>
    <div>
        {!! QrCode::size(100)->generate($barang->seri_barang) !!}
    </div>
    <p style="margin: 0;">Jenis: {{ $barang->jenis->jenis }}</p>
    <p style="margin: 0;">Lokasi: {{ $barang->lokasi->lokasi }}</p>
</body>
</html>
