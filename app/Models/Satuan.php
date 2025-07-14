<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    protected $table = 'satuans'; // Sesuaikan dengan nama tabel di migration
    protected $fillable = ['satuan', 'keterangan'];
}
