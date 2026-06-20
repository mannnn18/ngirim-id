<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function track($resi)
    {
        // Cari paket berdasarkan nomor resi dan panggil relasi 'tracking'
        $paket = Paket::with(['pengirim', 'penerima', 'tracking' => function($query) {
            // Urutkan dari yang paling terbaru berdasarkan kolom 'waktu'
            $query->orderBy('waktu', 'desc');
        }])->where('resi', $resi)->first();

        // Jika resi tidak ditemukan
        if (!$paket) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor resi tidak ditemukan atau tidak valid.',
                'data'    => null
            ], 404);
        }

        // Susun format data sejarah perjalanan paket dari tabel tracking
        $history = [];
        foreach ($paket->tracking as $track) {
            $history[] = [
                'tanggal' => date('d M Y H:i', strtotime($track->waktu)),
                'lokasi'  => $track->lokasi,
                'status'  => $track->status
            ];
        }

        // Jika berhasil, kembalikan data dalam format JSON
        return response()->json([
            'success' => true,
            'message' => 'Data resi berhasil ditemukan.',
            'data'    => [
                'resi'            => $paket->resi,
                'status_saat_ini' => $paket->status,
                'pengirim'        => $paket->pengirim->nama,
                'penerima'        => $paket->penerima->nama,
                'isi_paket'       => $paket->isi_paket,
                'berat'           => $paket->berat . ' Kg',
                'riwayat'         => $history
            ]
        ], 200);
    }
}