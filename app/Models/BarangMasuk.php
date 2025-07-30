<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    protected $table = 'barang_masuk';

   protected $fillable = ['barang_id', 'jenis_id', 'jumlah', 'tanggal_masuk', 'lampiran'];

    public function barang()
{
    return $this->belongsTo(Barang::class);
}

    public function jenis()
{
    return $this->belongsTo(Jenis::class);
}


}