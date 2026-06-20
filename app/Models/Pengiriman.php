<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    protected $table = 'pengiriman';
    protected $primaryKey = 'id_pengiriman';
    protected $guarded = [];

    public function paket() {
        return $this->belongsTo(Paket::class, 'id_paket');
    }

    public function kurir() {
        return $this->belongsTo(Kurir::class, 'id_kurir');
    }
    // Tambahkan ini di dalam class Paket (app/Models/Paket.php)
    
}