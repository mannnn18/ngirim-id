<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kurir', function (Blueprint $table) {
            $table->id('id_kurir'); // PK
            $table->string('nama', 100);
            $table->string('no_hp', 20);
            
            // Membuat kolom untuk ID Cabang (Harus bertipe sama dengan PK di tabel cabang, yaitu unsignedBigInteger)
            $table->unsignedBigInteger('id_cabang'); 
            
            // Mendefinisikan Relasi / Foreign Key
            $table->foreign('id_cabang')
                  ->references('id_cabang') // Merujuk ke kolom id_cabang
                  ->on('cabang')            // Di tabel cabang
                  ->onDelete('cascade');    // Jika cabang dihapus, data kurirnya ikut terhapus otomatis
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kurir');
    }
};