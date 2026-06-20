<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Berdasarkan pesan error Anda, nama tabelnya adalah 'paket' (tanpa 's')
        Schema::table('paket', function (Blueprint $table) {
            
            // 1. Putuskan "Kabel" pengikat lama yang mengarah ke tabel users
            $table->dropForeign('paket_id_pengirim_foreign');
            $table->dropForeign('paket_id_penerima_foreign');

            // 2. Sambungkan "Kabel" pengikat baru ke tabel pelanggans
            $table->foreign('id_pengirim')->references('id_pelanggan')->on('pelanggans')->onDelete('cascade');
            $table->foreign('id_penerima')->references('id_pelanggan')->on('pelanggans')->onDelete('cascade');
            
        });
    }

    public function down()
    {
        Schema::table('paket', function (Blueprint $table) {
            $table->dropForeign(['id_pengirim']);
            $table->dropForeign(['id_penerima']);
        });
    }
};