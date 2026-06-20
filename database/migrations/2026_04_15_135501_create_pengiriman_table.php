<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pengiriman', function (Blueprint $table) {
            $table->id('id_pengiriman');
            $table->unsignedBigInteger('id_paket');
            $table->string('asal', 100);
            $table->string('tujuan', 100);
            $table->dateTime('tanggal_kirim');
            $table->dateTime('estimasi_sampai');
            $table->decimal('biaya', 10, 2);
            $table->unsignedBigInteger('id_kurir')->nullable(); // Kurir bisa kosong saat paket baru dibuat
            
            // Relasi
            $table->foreign('id_paket')->references('id_paket')->on('paket')->onDelete('cascade');
            $table->foreign('id_kurir')->references('id_kurir')->on('kurir')->onDelete('set null');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('pengiriman'); }
};