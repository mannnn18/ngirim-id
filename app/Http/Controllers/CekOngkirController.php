<?php

namespace App\Http\Controllers;

use App\Models\Tarif; 
use App\Models\Cabang; // WAJIB DITAMBAHKAN agar bisa memanggil tabel Cabang
use Illuminate\Http\Request;

class CekOngkirController extends Controller
{
    // Menampilkan halaman awal Cek Ongkir
    public function index()
    {
        // PERBAIKAN BUG: Ambil dari tabel Cabang agar semua kota muncul (bukan dari Tarif)
        $semua_cabang = Cabang::all();
        
        return view('publik.cek_ongkir', compact('semua_cabang'));
    }

    // Memproses perhitungan tarif (Tombol HITUNG ditekan)
    public function hitung(Request $request)
    {
        $request->validate([
            'asal' => 'required',
            'tujuan' => 'required',
            'berat' => 'required|numeric|min:1'
        ]);

        // Mencari tarif yang cocok di database
        $tarif = Tarif::where('kota_asal', $request->asal)
                      ->where('kota_tujuan', $request->tujuan)
                      ->first();

        // Tetap kirim data cabang untuk dropdown agar pilihan tidak hilang
        $semua_cabang = Cabang::all();

        return view('publik.cek_ongkir', [
            'semua_cabang' => $semua_cabang,
            'hasil' => $tarif,
            'input_berat' => $request->berat,
            'input_asal' => $request->asal,
            'input_tujuan' => $request->tujuan
        ]);
    }
}