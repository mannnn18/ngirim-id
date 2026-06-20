<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('paket', function (Blueprint $table) {
        $table->string('kategori')->nullable()->after('isi_paket'); // Contoh: Elektronik, Dokumen, dll
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pakets', function (Blueprint $table) {
            //
        });
    }
    
};
