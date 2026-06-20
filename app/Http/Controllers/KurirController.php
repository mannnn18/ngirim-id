<?php

namespace App\Http\Controllers;

use App\Models\Kurir;
use App\Models\Cabang;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Paket;

class KurirController extends Controller
{
    public function index()
    {
        // ----------------------------------------------------------------
        // TRIK SIMULASI LOGIN (Hanya untuk testing)
        // Ganti angka 1 dengan ID user 'admin_pusat' atau 'admin_cabang' yang ada di databasemu
        $user_login = auth()->user();
        // ----------------------------------------------------------------

        // LOGIKA HAK AKSES
        if ($user_login->role === 'admin_pusat') {
            // Pusat: Bebas melihat semua kurir di seluruh Indonesia
            $data_kurir = Kurir::with('cabang')->get();
        } else {
            // Cabang: Hanya mengambil kurir yang id_cabang-nya sama dengan id_cabang si admin
            $data_kurir = Kurir::with('cabang')
                               ->where('id_cabang', $user_login->id_cabang)
                               ->get();
        }

        return view('kurir.index', compact('data_kurir'));
    }

    public function create()
    {
        // Simulasi Login yang sama
        $user_login = auth()->user();

        if ($user_login->role === 'admin_pusat') {
            // Pusat: Opsi dropdown menampilkan semua cabang
            $data_cabang = Cabang::all();
        } else {
            // Cabang: Opsi dropdown hanya menampilkan cabang miliknya sendiri
            $data_cabang = Cabang::where('id_cabang', $user_login->id_cabang)->get();
        }

        return view('kurir.create', compact('data_cabang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'no_hp' => 'required',
            'id_cabang' => 'required'
        ]);

        Kurir::create($request->all());

        return redirect('/kurir')->with('success', 'Kurir berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kurir = Kurir::findOrFail($id);
        $data_cabang = Cabang::all(); // Tetap panggil data cabang untuk pilihan dropdown
        
        return view('kurir.edit', compact('kurir', 'data_cabang'));
    }

    // Fungsi untuk menyimpan perubahan data
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'      => 'required',
            'no_hp'     => 'required',
            'id_cabang' => 'required'
        ]);

        $kurir = Kurir::findOrFail($id);
        $kurir->update([
            'nama'      => $request->nama,
            'no_hp'     => $request->no_hp,
            'id_cabang' => $request->id_cabang,
        ]);

        return redirect('/kurir')->with('success', 'Data kurir berhasil diperbarui!');
    }

    // Fungsi untuk menghapus data (Pecat Kurir)
    public function destroy($id)
    {
        $kurir = Kurir::findOrFail($id);
        $kurir->delete();

        return redirect('/kurir')->with('success', 'Data kurir berhasil dihapus!');
    }
    public function daftarAntaran()
{
    $kurir = auth()->user();
    
    // Hanya ambil paket yang statusnya 'Tiba di Cabang' dan berada di cabang si kurir
    $paket_tersedia = Paket::where('status', 'Tiba di Cabang')
                            ->where('id_cabang', $kurir->id_cabang)
                            ->get();

    return view('kurir.daftar_antaran', compact('paket_tersedia'));
}

public function klaimAntaran(Request $request)
{
    $request->validate([
        'id_paket' => 'required|array' // Harus mengirim array ID paket
    ]);

    $id_kurir = auth()->user()->id_user;

    foreach ($request->id_paket as $id) {
        $paket = Paket::find($id);
        $paket->update([
            'status' => 'Sedang Diantar',
            'id_kurir' => $id_kurir
        ]);

        // Catat riwayat pengiriman secara otomatis
        \App\Models\Pengiriman::create([
            'id_paket' => $id,
            'id_kurir' => $id_kurir,
            'status_pengiriman' => 'Sedang Diantar oleh Kurir',
            'tanggal_kirim' => now(),
            'asal' => 'Kantor Cabang',
            'tujuan' => 'Alamat Penerima',
            'biaya' => 0 // Klaim kurir tidak menambah biaya ongkir lagi
        ]);
    }

    return redirect('/kurir/antaran-saya')->with('success', 'Paket berhasil diklaim dan siap diantar!');
 }
 // ==========================================
    // 1. Menampilkan halaman paket yang sedang dibawa kurir
    // ==========================================
    public function antaranAktif()
    {
        $kurir = auth()->user();
        
        // Cari paket yang ID Kurir-nya adalah saya, dan statusnya "Sedang Diantar"
        $paket_aktif = \App\Models\Paket::where('id_kurir', $kurir->id_user)
                            ->where('status', 'Sedang Diantar')
                            ->get();

        return view('kurir.antaran_aktif', compact('paket_aktif'));
    }

    // ==========================================
    // 2. Memproses upload foto dan menyelesaikan tugas
    // ==========================================
    public function selesaikanAntaran(Request $request, $id)
    {
        $request->validate([
            'foto_bukti' => 'required|image|mimes:jpeg,png,jpg|max:3048', // Maksimal 3MB
            'nama_penerima_asli' => 'required|string'
        ]);

        $paket = \App\Models\Paket::findOrFail($id);

        // Upload Gambar ke folder public/storage/bukti_pengiriman
        $fotoPath = $request->file('foto_bukti')->store('bukti_pengiriman', 'public');

        // Update status paket jadi Selesai
        $paket->update([
            'status' => 'Selesai',
            'foto_bukti' => $fotoPath,
            'nama_penerima_asli' => $request->nama_penerima_asli
        ]);

        // Catat di riwayat tracking (Menggunakan Null-Safe operator untuk jaga-jaga)
        \App\Models\Pengiriman::create([
            'id_paket' => $id,
            'id_kurir' => auth()->user()->id_user,
            'status_pengiriman' => 'Paket Telah Diterima oleh: ' . $request->nama_penerima_asli,
            'tanggal_kirim' => now(),
            'asal' => 'Kurir',
            'tujuan' => 'Penerima',
            'biaya' => 0
        ]);

        return redirect('/kurir/antaran-aktif')->with('success', 'Kerja bagus! Antaran berhasil diselesaikan.');
    }
}