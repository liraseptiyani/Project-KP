<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;

    protected $table = 'barang_masuk'; // pastikan ini sesuai nama tabel di DB
    protected $fillable = ['tanggal_masuk', 'kode_barang', 'lampiran'];

    public function barang()
    {
        return $this->belongsTo(MasterBarang::class, 'kode_barang');
    }
}
