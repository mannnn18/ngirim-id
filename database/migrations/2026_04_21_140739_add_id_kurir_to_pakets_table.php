<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Sesuaikan nama tabel 'paket' atau 'paket' sesuai database Anda
        Schema::table('paket', function (Blueprint $table) {
            $table->unsignedBigInteger('id_kurir')->nullable()->after('status');
        });
    }

    public function down()
    {
        Schema::table('paket', function (Blueprint $table) {
            $table->dropColumn('id_kurir');
        });
    }
};