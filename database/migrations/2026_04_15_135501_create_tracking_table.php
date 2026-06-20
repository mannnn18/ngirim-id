<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tracking', function (Blueprint $table) {
            $table->id('id_tracking');
            $table->unsignedBigInteger('id_paket');
            $table->string('lokasi', 100);
            $table->string('status', 100);
            $table->dateTime('waktu');
            
            $table->foreign('id_paket')->references('id_paket')->on('paket')->onDelete('cascade');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('tracking'); }
};