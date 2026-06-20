<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Models\Pengiriman;
use App\Models\Kurir;
use App\Models\Cabang;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
   public function index()
    {
        $user = auth()->user();

        // ==========================================
        // 1. DASHBOARD KHUSUS KURIR
        // ==========================================
        if ($user->role === 'kurir') {
            $total_selesai = \App\Models\Paket::where('id_kurir', $user->id_user)
                                              ->where('status', 'Selesai')
                                              ->count();
            $total_komisi = $total_selesai * 500;

            return view('dashboard.kurir', compact('total_selesai', 'total_komisi'));
        }

        // ==========================================
        // 2. DASHBOARD KHUSUS ADMIN CABANG
        // ==========================================
        if ($user->role === 'admin_cabang') {
            // 4 Kotak Statistik (Khusus Cabang ini)
            $total_paket = \App\Models\Paket::where('id_cabang', $user->id_cabang)->count();
            $paket_aktif = \App\Models\Paket::where('id_cabang', $user->id_cabang)->where('status', 'Sedang Diantar')->count();
            $total_kurir = \App\Models\User::where('role', 'kurir')->where('id_cabang', $user->id_cabang)->count();
            
            // Tabel Paket Terbaru (Ambil 5 data terakhir di cabang ini)
            $paket_terbaru = \App\Models\Paket::where('id_cabang', $user->id_cabang)
                                              ->latest() // Urutkan dari yang paling baru
                                              ->take(5)  // Ambil 5 saja
                                              ->get();
        } 
        // ==========================================
        // 3. DASHBOARD KHUSUS ADMIN PUSAT
        // ==========================================
        else {
            // 4 Kotak Statistik (Seluruh Indonesia)
            $total_paket = \App\Models\Paket::count();
            $paket_aktif = \App\Models\Paket::where('status', 'Sedang Diantar')->count();
            $total_kurir = \App\Models\User::where('role', 'kurir')->count();
            
            // Tabel Paket Terbaru (Ambil 5 data terakhir dari semua cabang)
            $paket_terbaru = \App\Models\Paket::latest()->take(5)->get();
        }

        // Estimasi Pendapatan
        $total_pendapatan = $total_paket * 15000;

        // KIRIM SEMUA 5 VARIABEL KE INDEX.BLADE.PHP
        return view('dashboard.index', compact(
            'total_paket', 
            'total_pendapatan', 
            'paket_aktif', 
            'total_kurir', 
            'paket_terbaru' // <--- INI OBATNYA!
        )); 
    }
}