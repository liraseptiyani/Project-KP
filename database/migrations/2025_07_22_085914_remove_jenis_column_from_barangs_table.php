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
    Schema::table('barangs', function (Blueprint $table) {
        $table->dropColumn('jenis'); // Hapus kolom 'jenis'
    });
}

public function down()
{
    Schema::table('barangs', function (Blueprint $table) {
        // Jika Anda perlu rollback, tambahkan kembali kolomnya di sini
        $table->string('jenis')->nullable(); // Sesuaikan tipe dan nullable
    });
}
};
