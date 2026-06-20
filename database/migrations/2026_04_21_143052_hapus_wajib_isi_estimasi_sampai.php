<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Trik khusus PostgreSQL: Langsung cabut aturan "NOT NULL" dari database
        DB::statement('ALTER TABLE pengiriman ALTER COLUMN estimasi_sampai DROP NOT NULL');
    }

    public function down()
    {
        // Jika ingin dikembalikan seperti semula
        DB::statement('ALTER TABLE pengiriman ALTER COLUMN estimasi_sampai SET NOT NULL');
    }
};