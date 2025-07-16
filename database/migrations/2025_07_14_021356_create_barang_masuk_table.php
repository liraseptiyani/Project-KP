<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangMasukTable extends Migration
{
    public function up()
    {
        Schema::create('barang_masuk', function (Blueprint $table) {
            $table->id(); // ID Barang Masuk (auto increment)
            $table->date('tanggal_masuk'); // Tanggal masuk barang
            $table->unsignedBigInteger('kode_barang'); // FK ke master_barang
            $table->string('lampiran')->nullable(); // File lampiran optional
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('kode_barang')->references('id')->on('master_barang')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('barang_masuk');
    }
}
