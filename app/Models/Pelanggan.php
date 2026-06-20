<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    // Jika nama tabel kamu di database berbeda, sesuaikan di sini (contoh: 'pelanggan' atau 'pelanggans')
    protected $table = 'pelanggans'; 
    
    // Beri tahu primary key-nya apa
    protected $primaryKey = 'id_pelanggan'; 

    // Kolom-kolom yang diizinkan untuk diisi otomatis lewat form
    protected $fillable = [
        'nama',
        'no_hp',
        'alamat'
    ];
}