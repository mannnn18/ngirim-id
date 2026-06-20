<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Penting untuk membuat teks random (Resi)

class PaketController extends Controller
{
    public function index()
    {
        // Trik Simulasi Login (Ganti ID sesuai kebutuhan pengetesanmu)
        $user_login = auth()->user();

        if ($user_login->role === 'admin_pusat') {
            // Admin Pusat: Lihat semua paket di sistem
            $data_paket = Paket::with(['pengirim', 'penerima'])->latest()->get();
        } else {
            // Admin Cabang: HANYA lihat paket yang id_cabang-nya sama dengan miliknya
            $data_paket = Paket::with(['pengirim', 'penerima'])
                               ->where('id_cabang', $user_login->id_cabang)
                               ->latest()
                               ->get();
        }

        return view('paket.index', compact('data_paket'));
    }

    public function create()
    {
        // Ambil data cabang untuk dropdown Tujuan
        $data_cabang = \App\Models\Cabang::all();
        // Ambil data user yang mendaftar lewat web publik
        $pelanggan_terdaftar = \App\Models\User::where('role', 'pelanggan')->get();
        
        return view('paket.create', compact('data_cabang', 'pelanggan_terdaftar'));
    }

    // 1. UPDATE FUNGSI STORE
    public function store(Request $request)
    {
        $request->validate([
            'nama_pengirim' => 'required', 'telp_pengirim' => 'required', 'alamat_pengirim' => 'required',
            'nama_penerima' => 'required', 'telp_penerima' => 'required', 'alamat_penerima' => 'required',
            'isi_paket' => 'required', 'kategori' => 'required', 'berat' => 'required|numeric',
            'id_cabang_tujuan' => 'required',
            'metode_pembayaran' => 'required|in:Cash,Transfer' // Validasi metode pembayaran
        ]);

        $pengirim = \App\Models\Pelanggan::create([
            'nama' => $request->nama_pengirim, 'no_hp' => $request->telp_pengirim, 'alamat' => $request->alamat_pengirim
        ]);

        $penerima = \App\Models\Pelanggan::create([
            'nama' => $request->nama_penerima, 'no_hp' => $request->telp_penerima, 'alamat' => $request->alamat_penerima
        ]);

        // Hitung harga otomatis (Contoh: Rp 15.000 per Kg)
        // 1. Ambil data kota asal dan tujuan
        $kota_asal = auth()->user()->cabang->kota ?? '';
        $cabang_tujuan = \App\Models\Cabang::find($request->id_cabang_tujuan);
        $kota_tujuan = $cabang_tujuan->kota ?? '';

        // 2. Cari tarif di database
        $tarif = \App\Models\Tarif::where('kota_asal', $kota_asal)
                                  ->where('kota_tujuan', $kota_tujuan)
                                  ->first();

        // 3. Kalikan berat dengan harga tarif (atau default 15000 jika rute belum dibuat tarifnya)
        $harga_per_kg = $tarif ? $tarif->harga_per_kg : 15000;
        $total_harga = $request->berat * $harga_per_kg;

        \App\Models\Paket::create([
            'resi' => 'NGR-' . date('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(4)),
            'id_pengirim' => $pengirim->id_pelanggan,
            'id_penerima' => $penerima->id_pelanggan,
            'isi_paket' => $request->isi_paket,
            'kategori' => $request->kategori,
            'berat' => $request->berat,
            'status' => 'Diterima di Cabang Asal',
            'id_cabang' => auth()->user()->id_cabang ?? 1, 
            'id_cabang_tujuan' => $request->id_cabang_tujuan,
            // Simpan data pembayaran
            'harga' => $total_harga,
            'metode_pembayaran' => $request->metode_pembayaran,
            'status_pembayaran' => 'Lunas' // Asumsi langsung dibayar di cabang
        ]);

        return redirect('/paket')->with('success', 'Paket berhasil didaftarkan dan Lunas!');
    }

    // 2. TAMBAHKAN FUNGSI CETAK RESI (Letakkan di bagian paling bawah class)
    public function cetakResi($id)
    {
        $paket = \App\Models\Paket::findOrFail($id);
        return view('paket.resi', compact('paket'));
    }
    // Untuk fitur hapus paket (Edit biasanya jarang ada di resi, tapi bisa kita buat nanti kalau butuh)
    public function destroy($id)
    {
        $paket = Paket::findOrFail($id);
        $paket->delete();

        return redirect('/paket')->with('success', 'Data paket berhasil dibatalkan/dihapus!');
    }
    public function edit($id)
    {
        $paket = Paket::with(['pengirim', 'penerima'])->findOrFail($id);
        return view('paket.edit', compact('paket'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
        ]);

        $paket = Paket::findOrFail($id);
        
        // Kita hanya mengizinkan admin mengubah status dan isi paket saja
        $paket->update([
            'status' => $request->status,
            'isi_paket' => $request->isi_paket ?? $paket->isi_paket,
        ]);

        return redirect('/paket')->with('success', 'Status paket berhasil diperbarui!');
    }
    
}