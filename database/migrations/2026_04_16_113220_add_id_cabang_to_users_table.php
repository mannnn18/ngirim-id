<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom id_cabang yang boleh kosong (nullable)
            // Kenapa nullable? Karena Admin Pusat dan Pelanggan tidak terikat pada 1 cabang
            $table->unsignedBigInteger('id_cabang')->nullable()->after('role');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('id_cabang');
        });
    }
};