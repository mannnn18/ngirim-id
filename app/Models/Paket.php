<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    protected $table = 'paket';
    protected $primaryKey = 'id_paket';
    protected $guarded = [];

   // Relasi ke Pengirim (Pelanggan)
    public function pengirim()
    {
        // Parameter: (Nama Model, Foreign Key di tabel paket, Primary Key di tabel pelanggan)
        return $this->belongsTo(Pelanggan::class, 'id_pengirim', 'id_pelanggan');
    }

    // Relasi ke Penerima (Pelanggan)
    public function penerima()
    {
        return $this->belongsTo(Pelanggan::class, 'id_penerima', 'id_pelanggan');
    }
    // Relasi untuk mengambil riwayat tracking
    public function tracking()
    {
        return $this->hasMany(Tracking::class, 'id_paket')->orderBy('waktu', 'desc');
    }
    // Relasi ke Cabang Asal
    public function cabang()
    {
        return $this->belongsTo(\App\Models\Cabang::class, 'id_cabang', 'id_cabang');
    }

    // Relasi ke Cabang Tujuan
    public function cabangTujuan()
    {
        return $this->belongsTo(\App\Models\Cabang::class, 'id_cabang_tujuan', 'id_cabang');
    }
    public function pengiriman()
    {
        return $this->hasMany(Pengiriman::class, 'id_paket');
    }
}