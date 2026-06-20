<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Jurus paksa menggunakan perintah asli PostgreSQL
        // IF NOT EXISTS akan memastikan tidak ada error bentrok
        DB::statement('ALTER TABLE paket ADD COLUMN IF NOT EXISTS foto_bukti VARCHAR(255)');
        DB::statement('ALTER TABLE paket ADD COLUMN IF NOT EXISTS nama_penerima_asli VARCHAR(255)');
    }

    public function down()
    {
        DB::statement('ALTER TABLE paket DROP COLUMN IF EXISTS foto_bukti');
        DB::statement('ALTER TABLE paket DROP COLUMN IF EXISTS nama_penerima_asli');
    }
};
