<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use Illuminate\Http\Request;

class CabangController extends Controller
{
    public function index()
    {
        $data_cabang = Cabang::all();
        return view('cabang.index', compact('data_cabang'));
    }

    // 1. Fungsi untuk menampilkan halaman formulir
    public function create()
    {
        // TAMBAHKAN 3 BARIS INI:
        if (auth()->user()->role !== 'admin_pusat') {
            return redirect('/cabang')->with('error', 'Hanya Admin Pusat yang boleh menambah cabang!');
        }
        
        return view('cabang.create');
    }

    // 2. Fungsi untuk menangkap data dari form dan menyimpannya ke database
    public function store(Request $request)
    {
        // Validasi: Pastikan data tidak boleh kosong
        $request->validate([
            'nama_cabang' => 'required|string|max:100',
            'kota'        => 'required|string|max:50',
            'alamat'      => 'required'
        ]);

        // Simpan ke database Supabase
        Cabang::create([
            'nama_cabang' => $request->nama_cabang,
            'kota'        => $request->kota,
            'alamat'      => $request->alamat,
        ]);

        // Kembali ke halaman index cabang dengan pesan sukses
        return redirect('/cabang')->with('success', 'Cabang baru berhasil ditambahkan!');
    }

    // 3. Fungsi untuk menampilkan form edit dengan data lama
    public function edit($id)
    {
        // TAMBAHKAN 3 BARIS INI JUGA:
        if (auth()->user()->role !== 'admin_pusat') {
            return redirect('/cabang')->with('error', 'Akses ditolak!');
        }

        $cabang = Cabang::findOrFail($id);
        return view('cabang.edit', compact('cabang'));
    }
    // 4. Fungsi untuk menyimpan perubahan ke database
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_cabang' => 'required|string|max:100',
            'kota'        => 'required|string|max:50',
            'alamat'      => 'required'
        ]);

        $cabang = Cabang::findOrFail($id);
        $cabang->update([
            'nama_cabang' => $request->nama_cabang,
            'kota'        => $request->kota,
            'alamat'      => $request->alamat,
        ]);

        return redirect('/cabang')->with('success', 'Data cabang berhasil diperbarui!');
    }

    // 5. Fungsi untuk menghapus data
    public function destroy($id)
    {
        $cabang = Cabang::findOrFail($id);
        $cabang->delete();

        return redirect('/cabang')->with('success', 'Data cabang berhasil dihapus!');
    }
}