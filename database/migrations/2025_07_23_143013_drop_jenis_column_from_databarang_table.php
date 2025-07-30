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
    Schema::table('databarang', function (Blueprint $table) {
        $table->dropColumn('jenis');
    });
}

public function down()
{
    Schema::table('databarang', function (Blueprint $table) {
        $table->string('jenis')->nullable();
    });
}

};
