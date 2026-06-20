<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('paket', function (Blueprint $table) {
            $table->id('id_paket');
            $table->string('resi', 50)->unique();
            $table->unsignedBigInteger('id_pengirim');
            $table->unsignedBigInteger('id_penerima');
            $table->decimal('berat', 5, 2);
            $table->text('isi_paket');
            $table->string('status', 50);
            
            // Relasi ke tabel users
            $table->foreign('id_pengirim')->references('id_user')->on('users');
            $table->foreign('id_penerima')->references('id_user')->on('users');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('paket'); }
};