<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanBarang extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_peminjaman',
        'tanggal_peminjaman',
        'tanggal_pengembalian',
        'nama_peminjam',
        'divisi',
        'nama_barang',
        'jumlah_barang',
        'status',
        'catatan',
    ];
}
