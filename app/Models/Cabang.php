<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    // 1. Kasih tau nama tabelnya
    protected $table = 'cabang';

    // 2. Kasih tau Primary Key-nya
    protected $primaryKey = 'id_cabang';

    // 3. Izinkan semua kolom diisi (mass assignment)
    protected $guarded = [];
}