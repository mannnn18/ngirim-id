<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Models\Cabang;
use App\Models\Pengiriman;
use Illuminate\Http\Request;

class TransitController extends Controller
{
    // 1. Halaman Kirim Paket ke Cabang Lain
    public function indexKirim()
    {
        $admin = auth()->user();
        
        // Cari paket di cabang ini yang tujuannya BUKAN cabang ini, dan statusnya masih antre
        $paket_siap_kirim = Paket::where('id_cabang', $admin->id_cabang)
                                 ->whereColumn('id_cabang', '!=', 'id_cabang_tujuan')
                                 ->whereIn('status', ['Diterima di Cabang Asal', 'Tiba di Cabang Transit'])
                                 ->get();
                                 
        $cabang_tujuan = Cabang::where('id_cabang', '!=', $admin->id_cabang)->get();

        return view('transit.kirim', compact('paket_siap_kirim', 'cabang_tujuan'));
    }

    // 2. Proses Pengiriman (Bulk Update)
    // 2. Proses Pengiriman (Bulk Update)
    public function prosesKirim(Request $request)
    {
        $request->validate(['id_paket' => 'required|array']);

        foreach ($request->id_paket as $id) {
            $paket = Paket::find($id);
            $paket->update(['status' => 'Menuju Cabang Tujuan']);

            // Catat history tracking dengan Null-Safe Operator (?->) agar anti-error
            Pengiriman::create([
                'id_paket' => $id,
                'status_pengiriman' => 'Paket diberangkatkan menuju ' . ($paket->cabangTujuan?->nama_cabang ?? 'Tujuan Akhir'),
                'tanggal_kirim' => now(),
                'asal' => auth()->user()->cabang?->nama_cabang ?? 'Pusat',
                'tujuan' => $paket->cabangTujuan?->nama_cabang ?? 'Tujuan Akhir',
                'biaya' => 0
            ]);
        }
        return back()->with('success', count($request->id_paket) . ' Paket berhasil diberangkatkan!');
    }

    // 3. Halaman Terima Paket dari Cabang Lain
    public function indexTerima()
    {
        $admin = auth()->user();
        
        // Cari paket yang sedang OTW ke cabang ini
        $paket_masuk = Paket::where('id_cabang_tujuan', $admin->id_cabang)
                            ->where('status', 'Menuju Cabang Tujuan')
                            ->get();

        return view('transit.terima', compact('paket_masuk'));
    }

    // 4. Proses Penerimaan (Bulk Update)
    public function prosesTerima(Request $request)
    {
        $request->validate(['id_paket' => 'required|array']);
        $admin = auth()->user();

        foreach ($request->id_paket as $id) {
            $paket = Paket::find($id);
            $paket->update([
                'status' => 'Tiba di Cabang',
                'id_cabang' => $admin->id_cabang // Pindahkan posisi paket ke cabang ini
            ]);

            // Catat history tracking
            Pengiriman::create([
                'id_paket' => $id,
                'status_pengiriman' => 'Paket telah tiba di ' . $admin->cabang->nama_cabang,
                'tanggal_kirim' => now(),
                'asal' => 'Perjalanan Transit',
                'tujuan' => $admin->cabang->nama_cabang,
                'biaya' => 0
            ]);
        }
        return back()->with('success', count($request->id_paket) . ' Paket berhasil diterima di cabang ini!');
    }
}