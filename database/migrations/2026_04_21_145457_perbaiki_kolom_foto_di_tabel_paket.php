<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Pastikan kali ini kita menembak tabel 'paket' (TANPA HURUF S)
        Schema::table('paket', function (Blueprint $table) {
            
            // Cek dan pasang kolom foto_bukti jika belum ada
            if (!Schema::hasColumn('paket', 'foto_bukti')) {
                $table->string('foto_bukti')->nullable();
            }
            
            // Cek dan pasang kolom nama_penerima_asli jika belum ada
            if (!Schema::hasColumn('paket', 'nama_penerima_asli')) {
                $table->string('nama_penerima_asli')->nullable();
            }
            
        });
    }

    public function down()
    {
        Schema::table('paket', function (Blueprint $table) {
            $table->dropColumn(['foto_bukti', 'nama_penerima_asli']);
        });
    }
};