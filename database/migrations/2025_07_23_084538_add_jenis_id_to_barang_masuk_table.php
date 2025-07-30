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
    $table->unsignedBigInteger('jenis_id')->nullable(false)->change();
            // Jika kamu ingin foreign key constraint
            $table->foreign('jenis_id')->references('id')->on('jenis')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('barang_masuk', function (Blueprint $table) {
            $table->dropForeign(['jenis_id']);
            $table->dropColumn('jenis_id');
        });
    }
};
