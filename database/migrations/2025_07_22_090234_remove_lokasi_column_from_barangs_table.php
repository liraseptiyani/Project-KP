<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveLokasiColumnFromBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropColumn('lokasi'); // Hapus kolom 'lokasi'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('barangs', function (Blueprint $table) {
            // Untuk rollback, jika Anda perlu, tambahkan kembali kolomnya di sini
            $table->string('lokasi')->nullable(); // Sesuaikan tipe dan nullable
        });
    }
}