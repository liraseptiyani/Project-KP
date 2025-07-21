<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('barangs', function (Blueprint $table) {
        if (!Schema::hasColumn('barangs', 'no_urut')) {
            $table->unsignedInteger('no_urut')->after('id'); // nomor urut biasa
        }

        if (!Schema::hasColumn('barangs', 'jenis')) {
            $table->string('jenis')->after('no_urut'); // nama jenis (misal: PC DELL)
        }

        if (!Schema::hasColumn('barangs', 'seri_barang')) {
            $table->string('seri_barang')->after('jenis'); // hasil generate: D0001 dst
        }

        if (!Schema::hasColumn('barangs', 'satuan')) {
            $table->string('satuan')->after('seri_barang'); // nama satuan (misal: Unit)
        }

        if (!Schema::hasColumn('barangs', 'lokasi')) {
            $table->string('lokasi')->after('satuan'); // lokasi fisik (misal: Rak A)
        }

        if (!Schema::hasColumn('barangs', 'qr_code')) {
            $table->string('qr_code')->nullable()->after('lokasi'); // QR code
        }
    });
}

    public function down(): void
{
    Schema::table('barangs', function (Blueprint $table) {
        $table->dropColumn(['no_urut', 'jenis', 'seri_barang', 'satuan', 'lokasi', 'qr_code']);
    });
}

};
