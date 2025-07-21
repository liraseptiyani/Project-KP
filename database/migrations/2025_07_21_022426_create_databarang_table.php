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
        Schema::create('databarang', function (Blueprint $table) {
            $table->id(); // Ini akan membuat kolom 'id' sebagai primary key AUTO_INCREMENT
            $table->string('jenis'); // Contoh: kolom 'jenis' (sesuai yang Anda panggil di migrasi lain)
            $table->timestamps(); // Ini akan membuat kolom 'created_at' dan 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('databarang');
    }
};