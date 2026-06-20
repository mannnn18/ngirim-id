<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Membuat tabel pelanggans yang terlewat
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->id('id_pelanggan');
            $table->string('nama');
            $table->string('no_hp');
            $table->text('alamat');
            $table->timestamps();
        });

        // 2. Menambahkan kolom cabang tujuan di tabel paket
        Schema::table('paket', function (Blueprint $table) {
            $table->unsignedBigInteger('id_cabang_tujuan')->nullable()->after('id_cabang');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pelanggans');
        Schema::table('paket', function (Blueprint $table) {
            $table->dropColumn('id_cabang_tujuan');
        });
    }
};