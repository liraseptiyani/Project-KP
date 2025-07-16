<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan_barangs', function (Blueprint $table) {
            $table->id();
            $table->string('id_peminjaman')->unique(); // Contoh: PGM-XYZ123
            $table->date('tanggal_peminjaman');
            $table->date('tanggal_pengembalian');
            $table->string('nama_peminjam'); // Diisi manual
            $table->string('divisi'); // Diambil dari username login
            $table->string('nama_barang');
            $table->integer('jumlah_barang');
            $table->enum('status', ['menunggu', 'diterima', 'ditolak'])->default('menunggu');
            $table->text('catatan')->nullable(); // Diisi admin saat terima/tolak
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // untuk tahu siapa yang mengajukan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_barangs');
    }
};

