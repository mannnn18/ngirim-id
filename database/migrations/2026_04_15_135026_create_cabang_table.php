<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cabang', function (Blueprint $table) {
            $table->id('id_cabang');
            $table->string('nama_cabang', 100);
            $table->text('alamat');
            $table->string('kota', 50);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cabang');
    }
};