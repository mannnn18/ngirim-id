<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('paket', function (Blueprint $table) {
            $table->integer('harga')->default(0)->after('berat');
            $table->string('metode_pembayaran')->nullable()->after('harga'); // Cash atau Transfer
            $table->string('status_pembayaran')->default('Lunas')->after('metode_pembayaran');
        });
    }

    public function down()
    {
        Schema::table('paket', function (Blueprint $table) {
            $table->dropColumn(['harga', 'metode_pembayaran', 'status_pembayaran']);
        });
    }
};