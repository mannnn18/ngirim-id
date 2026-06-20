<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->unsignedBigInteger('id_paket');
            $table->string('metode', 50);
            $table->decimal('jumlah', 10, 2);
            $table->string('status', 50);
            $table->dateTime('tanggal_bayar')->nullable(); // Bisa null jika belum bayar
            
            $table->foreign('id_paket')->references('id_paket')->on('paket')->onDelete('cascade');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('pembayaran'); }
};