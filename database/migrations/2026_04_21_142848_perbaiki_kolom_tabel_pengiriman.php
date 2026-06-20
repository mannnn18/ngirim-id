<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Pastikan nama tabelnya sesuai dengan database Anda (pengiriman)
        Schema::table('pengiriman', function (Blueprint $table) {
            
            // Cek dan tambahkan status_pengiriman jika belum ada
            if (!Schema::hasColumn('pengiriman', 'status_pengiriman')) {
                $table->string('status_pengiriman')->nullable();
            }
            
            // Cek dan tambahkan tanggal_kirim jika belum ada
            if (!Schema::hasColumn('pengiriman', 'tanggal_kirim')) {
                $table->timestamp('tanggal_kirim')->nullable();
            }
            
            // Cek dan tambahkan asal jika belum ada
            if (!Schema::hasColumn('pengiriman', 'asal')) {
                $table->string('asal')->nullable();
            }
            
            // Cek dan tambahkan tujuan jika belum ada
            if (!Schema::hasColumn('pengiriman', 'tujuan')) {
                $table->string('tujuan')->nullable();
            }
            
            // Cek dan tambahkan biaya jika belum ada
            if (!Schema::hasColumn('pengiriman', 'biaya')) {
                $table->integer('biaya')->default(0);
            }
            
        });
    }

    public function down()
    {
        // Tidak perlu diisi untuk rollback darurat kali ini
    }
};