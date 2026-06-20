<?php

namespace App\Http\Controllers;

use App\Models\Pengiriman;
use App\Models\Paket;
use App\Models\Tarif;
use App\Models\Kurir;
use Illuminate\Http\Request;

class PengirimanController extends Controller
{
    // Menampilkan Form Proses (Jembatan dari tombol Hijau)
    public function create($id_paket)
    {
        $paket = Paket::findOrFail($id_paket);
        $data_tarif = Tarif::all(); // Untuk pilih rute
        $data_kurir = Kurir::all(); // Untuk pilih kurir penjemput
        
        return view('pengiriman.create', compact('paket', 'data_tarif', 'data_kurir'));
    }

    public function store(Request $request)
    {
        // 1. Ambil data tarif yang dipilih untuk mendapatkan harga per kg
        $tarif = Tarif::findOrFail($request->id_tarif);
        $paket = Paket::findOrFail($request->id_paket);

        // 2. LOGIKA KALKULATOR OTOMATIS
        $total_biaya = $paket->berat * $tarif->harga_per_kg;

        // 3. Simpan ke tabel pengiriman
        Pengiriman::create([
            'id_paket' => $request->id_paket,
            'asal' => $tarif->kota_asal,
            'tujuan' => $tarif->kota_tujuan,
            'tanggal_kirim' => now(),
            'estimasi_sampai' => now()->addDays($tarif->estimasi_hari),
            'biaya' => $total_biaya,
            'id_kurir' => $request->id_kurir,
        ]);

        // 4. Update otomatis status paket menjadi 'Sedang Diproses'
        $paket->update(['status' => 'Sedang Diproses']);

        return redirect('/paket')->with('success', 'Paket berhasil diproses! Biaya: Rp ' . number_format($total_biaya, 0, ',', '.'));
    }
}