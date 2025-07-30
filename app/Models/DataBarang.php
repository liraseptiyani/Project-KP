<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataBarang extends Model
{
    protected $table = 'databarang';

    protected $fillable = ['jenis_id', 'total_stok'];

    public function jenis()
    {
        return $this->belongsTo(Jenis::class);
    }

    public function barang()
{
    return $this->belongsTo(Barang::class);
}

}
