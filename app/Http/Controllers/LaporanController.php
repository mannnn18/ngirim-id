<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Models\Pengiriman;
use App\Models\Cabang;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index()
    {
        $data_cabang = Cabang::all();
        return view('laporan.index', compact('data_cabang'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
        ]);

        $user = auth()->user();
        $tgl_mulai = $request->tgl_mulai;
        $tgl_selesai = $request->tgl_selesai;

        // Query dasar untuk Pengiriman (Keuangan) dan Paket (Operasional)
        $query_pengiriman = Pengiriman::with(['paket'])
            ->whereBetween('tanggal_kirim', [$tgl_mulai . ' 00:00:00', $tgl_selesai . ' 23:59:59']);
        
        $query_paket = Paket::whereBetween('created_at', [$tgl_mulai . ' 00:00:00', $tgl_selesai . ' 23:59:59']);

        // Filter Cabang: Jika Admin Cabang, kunci ke cabangnya saja. 
        // Jika Admin Pusat, cek apakah ada filter cabang tertentu yang dipilih.
        if ($user->role === 'admin_cabang') {
            $id_cabang = $user->id_cabang;
            $query_paket->where('id_cabang', $id_cabang);
            // Pengiriman difilter lewat relasi paket
            $query_pengiriman->whereHas('paket', function($q) use ($id_cabang) {
                $q->where('id_cabang', $id_cabang);
            });
        } elseif ($request->id_cabang) {
            $id_cabang = $request->id_cabang;
            $query_paket->where('id_cabang', $id_cabang);
            $query_pengiriman->whereHas('paket', function($q) use ($id_cabang) {
                $q->where('id_cabang', $id_cabang);
            });
        }

        $laporan_keuangan = $query_pengiriman->get();
        $total_pendapatan = $laporan_keuangan->sum('biaya');
        $total_paket = $query_paket->count();
        
        // Statistik Status Paket
        $status_counts = $query_paket->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->get();

        return view('laporan.hasil', compact(
            'laporan_keuangan', 'total_pendapatan', 'total_paket', 
            'status_counts', 'tgl_mulai', 'tgl_selesai'
        ));
    }
}