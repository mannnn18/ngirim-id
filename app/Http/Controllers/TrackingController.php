<?php

namespace App\Http\Controllers;

use App\Models\Tracking;
use App\Models\Paket;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    // 1. FUNGSI ADMIN: Menyimpan update posisi paket terbaru
    public function store(Request $request)
    {
        $request->validate([
            'id_paket' => 'required',
            'lokasi'   => 'required',
            'status'   => 'required',
        ]);

        Tracking::create([
            'id_paket' => $request->id_paket,
            'lokasi'   => $request->lokasi,
            'status'   => $request->status,
            'waktu'    => now(), // Otomatis mengambil tanggal & jam saat ini
        ]);

        // Opsional: Update juga status utama di tabel paket agar sinkron
        $paket = Paket::findOrFail($request->id_paket);
        $paket->update(['status' => $request->status]);

        return back()->with('success', 'Update posisi paket berhasil ditambahkan!');
    }

    // 2. FUNGSI PUBLIK: Mencari resi dari halaman depan (Landing Page)
    public function search(Request $request)
    {
        $resi = $request->resi;
        $paket = null;

        // Jika user mengetikkan resi di kolom pencarian
        if ($resi) {
            // Cari paket berdasarkan resi, bawa juga data pengirim, penerima, dan riwayat tracking-nya
            $paket = Paket::with(['pengirim', 'penerima', 'tracking'])->where('resi', $resi)->first();
        }

        // Tampilkan halaman hasil lacak (nanti kita buat file ini)
        return view('tracking.result', compact('paket', 'resi'));
    }
}