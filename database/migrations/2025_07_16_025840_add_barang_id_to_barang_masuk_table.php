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
        $table->unsignedBigInteger('barang_id')->after('id');

        $table->foreign('barang_id')->references('id')->on('barangs')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('barang_masuk', function (Blueprint $table) {
        $table->dropForeign(['barang_id']);
        $table->dropColumn('barang_id');
    });
}

};
