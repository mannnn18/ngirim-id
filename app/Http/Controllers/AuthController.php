<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman Login
    public function index()
    {
        return view('auth.login');
    }

    // Memproses data form Login
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Coba mencocokkan email dan password dengan database
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // ----------------------------------------------------
            // POLISI LALU LINTAS: CEK ROLE SETELAH BERHASIL LOGIN
            // ----------------------------------------------------
            $user_role = auth()->user()->role;

            if ($user_role === 'pelanggan') {
                // Jika yang login adalah Pelanggan, lempar ke Halaman Depan
                return redirect()->intended('/');
            } else {
                // Jika yang login adalah Pegawai (Pusat/Cabang/Kurir), lempar ke Dashboard
                return redirect()->intended('/dashboard');
            }
        }

        // Jika gagal, kembalikan ke halaman login dengan pesan error
        return back()->with('error', 'Email atau Password salah!');
    }

    // Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda berhasil keluar dari sistem.');
    }
}