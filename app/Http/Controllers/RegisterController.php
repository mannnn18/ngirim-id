<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    // Menampilkan halaman form pendaftaran
    public function index()
    {
        return view('auth.register');
    }

    // Memproses data pendaftaran
    public function store(Request $request)
    {
        // 1. Validasi inputan (pastikan email belum pernah dipakai)
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string',
            'password' => 'required|string|min:6|confirmed', // Harus sama dengan password_confirmation
        ]);

        // 2. Simpan ke tabel users
        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'password' => Hash::make($request->password),
            'role' => 'pelanggan', // Kunci keamanan: Otomatis jadi pelanggan
            'id_cabang' => null
        ]);

        // 3. Langsung login-kan user tersebut setelah berhasil daftar
        Auth::login($user);

        // 4. Arahkan ke dashboard pelanggan (atau halaman utama)
        // Ganti redirect('/dashboard') menjadi:
        return redirect('/')->with('success', 'Akun berhasil dibuat! Silakan gunakan layanan kami.');
    }
}