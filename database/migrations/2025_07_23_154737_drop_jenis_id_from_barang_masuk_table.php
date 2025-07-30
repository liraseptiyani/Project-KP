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
    Schema::table('barang_masuk', function (Blueprint $table) {
        // Drop foreign key constraint dulu
        $table->dropForeign(['jenis_id']);
        // Baru drop kolomnya
        $table->dropColumn('jenis_id');
    });
}

public function down()
{
    Schema::table('barang_masuk', function (Blueprint $table) {
        $table->unsignedBigInteger('jenis_id')->nullable()->after('barang_id');
        $table->foreign('jenis_id')->references('id')->on('jenis')->onDelete('cascade');
    });
}


};
