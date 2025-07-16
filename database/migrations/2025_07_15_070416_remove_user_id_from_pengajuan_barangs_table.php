<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pengajuan_barangs', function (Blueprint $table) {
            // Hapus foreign key constraint dulu
            if (Schema::hasColumn('pengajuan_barangs', 'user_id')) {
                $table->dropForeign(['user_id']); // <-- ini penting
                $table->dropColumn('user_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pengajuan_barangs', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
        });
    }
};
