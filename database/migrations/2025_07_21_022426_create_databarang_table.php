<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('data_barang', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('barang_id');
        $table->integer('stok')->default(0);
        $table->timestamps();

        $table->foreign('barang_id')->references('id')->on('barangs')->onDelete('cascade');
    });
}

public function down()
{
    Schema::dropIfExists('data_barang');
}

};