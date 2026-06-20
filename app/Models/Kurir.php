<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kurir extends Model
{
    protected $table = 'kurir';
    protected $primaryKey = 'id_kurir';
    protected $guarded = [];

    // Relasi: Kurir dimiliki oleh satu Cabang
    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'id_cabang');
    }
}