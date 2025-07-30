<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    protected $fillable = [
        'barang_id',
        'nama_peminjam',
        'status',
        'tanggal_pengembalian',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}