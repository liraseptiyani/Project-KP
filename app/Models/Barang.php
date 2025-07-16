<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_barang',
        'seri_barang',
        'jenis_id',
        'satuan_id',
        'lokasi_id',
    ];

    // Relasi ke tabel lain
    public function jenis()
    {
        return $this->belongsTo(Jenis::class);
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class);
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }
}
