<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    Public function up()
{
    Schema::create('barangs', function (Blueprint $table) {
        $table->id();
        $table->string('kode_barang')->unique();   // otomatis
        $table->string('seri_barang')->unique();   // otomatis
        $table->unsignedBigInteger('jenis_id');    // dropdown
        $table->unsignedBigInteger('satuan_id');   // dropdown
        $table->unsignedBigInteger('lokasi_id');   // dropdown
        $table->timestamps();

        $table->foreign('jenis_id')->references('id')->on('jenis')->onDelete('cascade');
        $table->foreign('satuan_id')->references('id')->on('satuans')->onDelete('cascade');
        $table->foreign('lokasi_id')->references('id')->on('lokasis')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
