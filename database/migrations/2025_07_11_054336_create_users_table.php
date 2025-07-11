// database/migrations/xxxx_xx_xx_create_users_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique(); // Mengubah email menjadi username dan menjadikannya unik
            // $table->string('email')->unique(); // Hapus atau jadikan komentar baris ini
            // $table->timestamp('email_verified_at')->nullable(); // Hapus atau jadikan komentar baris ini
            $table->string('password');
            $table->enum('role', ['admin', 'user'])->default('user'); // Tambahkan kolom role
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};