<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            if (Schema::hasColumn('barangs', 'jenis')) {
                $table->renameColumn('jenis', 'jenis_id');
            }
            if (Schema::hasColumn('barangs', 'satuan')) {
                $table->renameColumn('satuan', 'satuan_id');
            }
            if (Schema::hasColumn('barangs', 'lokasi')) {
                $table->renameColumn('lokasi', 'lokasi_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            if (Schema::hasColumn('barangs', 'jenis_id')) {
                $table->renameColumn('jenis_id', 'jenis');
            }
            if (Schema::hasColumn('barangs', 'satuan_id')) {
                $table->renameColumn('satuan_id', 'satuan');
            }
            if (Schema::hasColumn('barangs', 'lokasi_id')) {
                $table->renameColumn('lokasi_id', 'lokasi');
            }
        });
    }
};
