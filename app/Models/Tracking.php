<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    protected $table = 'tracking';
    protected $primaryKey = 'id_tracking';
    protected $guarded = [];

    // Relasi: Setiap riwayat tracking pasti milik 1 paket
    public function paket()
    {
        return $this->belongsTo(Paket::class, 'id_paket');
    }
}