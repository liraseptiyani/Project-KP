<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        // Cek dulu: hanya tambahkan kolom kalau belum ada
        if (!Schema::hasColumn('jenis', 'prefix')) {
            Schema::table('jenis', function (Blueprint $table) {
                $table->string('prefix', 5)->nullable();
            });
        }

        // Tidak perlu copy dari kolom 'jenis' karena sudah tidak ada
        // Dan tidak perlu drop 'jenis' kalau sudah dihapus sebelumnya
    }

    public function down(): void
    {
        // Hanya hapus prefix kalau memang ada
        if (Schema::hasColumn('jenis', 'prefix')) {
            Schema::table('jenis', function (Blueprint $table) {
                $table->dropColumn('prefix');
            });
        }

        // Tambahkan kembali kolom jenis jika diperlukan (opsional)
        // Schema::table('jenis', function (Blueprint $table) {
        //     $table->string('jenis')->nullable();
        // });
    }
};
