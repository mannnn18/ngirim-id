<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Tambahkan ini di atas

return new class extends Migration
{
    public function up()
    {
        // 1. SAPU BERSIH DATA HANTU
        // Perintah ini akan menghapus riwayat pengiriman jika ID kurirnya tidak ditemukan di tabel users
        DB::statement('DELETE FROM pengiriman WHERE id_kurir NOT IN (SELECT id_user FROM users) AND id_kurir IS NOT NULL');

        Schema::table('pengiriman', function (Blueprint $table) {
            // 2. Putuskan kabel lama yang mengarah ke tabel 'kurir' (jika masih ada)
            $table->dropForeign('pengiriman_id_kurir_foreign');

            // 3. Sambungkan kabel baru yang mengarah ke tabel 'users'
            $table->foreign('id_kurir')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('pengiriman', function (Blueprint $table) {
            $table->dropForeign(['id_kurir']);
        });
    }
};