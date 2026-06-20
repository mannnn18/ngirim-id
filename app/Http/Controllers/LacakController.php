<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use Illuminate\Http\Request;

class LacakController extends Controller
{
    // Method ini sekarang menangani tampilan awal sekaligus memproses pencarian GET
    public function index(Request $request)
    {
        $resi = $request->query('resi'); // Menangkap teks resi dari URL
        $paket = null;

        // Jika form pencarian diisi
        if ($resi) {
            // Cari paket dan muat relasi tabel 'tracking' (BUKAN 'pengiriman')
            $paket = Paket::with(['pengirim', 'penerima', 'tracking' => function($query) {
                // Urutkan riwayat dari yang terbaru
                $query->orderBy('waktu', 'desc');
            }])->where('resi', $resi)->first();
        }

        // Tampilkan halaman lacak publik dan kirimkan data paket & resi
        return view('publik.lacak', compact('paket', 'resi'));
    }

    public function paketSaya()
    {
        // Tangkap data user yang sedang login
        $user = auth()->user();

        // FIX DATA LEAK: Cari paket di mana nama pengirimnya sama dengan nama user yang login
        $paket_saya = Paket::whereHas('pengirim', function($query) use ($user) {
            $query->where('nama', $user->nama);
        })->latest()->get();

        return view('publik.paket_saya', compact('paket_saya'));
    }
}