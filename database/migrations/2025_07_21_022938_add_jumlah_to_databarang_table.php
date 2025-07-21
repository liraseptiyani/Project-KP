<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('databarang', function (Blueprint $table) {
            // Menambahkan kolom 'jumlah' dengan tipe data integer
            // Anda bisa menyesuaikan tipe data (misal: decimal, float)
            // dan properti lainnya (misal: nullable, default) sesuai kebutuhan.
            $table->integer('jumlah')->after('jenis')->nullable(); 
            // ^^^ tambahkan baris ini ^^^
            // .after('jenis') akan menempatkan kolom 'jumlah' setelah kolom 'jenis'
            // .nullable() berarti kolom ini boleh kosong. Hapus jika harus selalu ada isinya.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('databarang', function (Blueprint $table) {
            // Menghapus kolom 'jumlah' jika migrasi dibatalkan
            $table->dropColumn('jumlah'); // ^^^ tambahkan baris ini ^^^
        });
    }
};