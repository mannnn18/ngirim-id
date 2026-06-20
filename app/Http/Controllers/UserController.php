<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cabang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Menampilkan daftar pengguna sesuai hak akses
    public function index()
    {
        $user_login = auth()->user();

        if ($user_login->role === 'admin_pusat') {
            // Pusat bisa melihat Admin Cabang dan Kurir (seluruh cabang)
            $users = User::whereIn('role', ['admin_cabang', 'kurir'])->latest()->get();
        } elseif ($user_login->role === 'admin_cabang') {
            // Cabang HANYA bisa melihat Kurir di cabangnya sendiri
            $users = User::where('role', 'kurir')
                         ->where('id_cabang', $user_login->id_cabang)
                         ->latest()->get();
        } else {
            return redirect('/dashboard')->with('error', 'Akses ditolak.');
        }

        return view('users.index', compact('users'));
    }

    // Menampilkan halaman tambah pengguna
    public function create()
    {
        $user_login = auth()->user();
        $data_cabang = Cabang::all();

        return view('users.create', compact('user_login', 'data_cabang'));
    }

    // Memproses pembuatan akun berdasarkan siapa yang membuat
    public function store(Request $request)
    {
        $user_login = auth()->user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string',
        ]);

        $role = '';
        $id_cabang = null;

        // Logika Hierarki:
        if ($user_login->role === 'admin_pusat') {
            // Jika Pusat yang buat -> Akun itu pasti Admin Cabang
            $request->validate(['id_cabang' => 'required']);
            $role = 'admin_cabang';
            $id_cabang = $request->id_cabang;
        } elseif ($user_login->role === 'admin_cabang') {
            // Jika Cabang yang buat -> Akun itu pasti Kurir (dikunci ke cabang pembuat)
            $role = 'kurir';
            $id_cabang = $user_login->id_cabang; 
        }

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'role' => $role,
            'id_cabang' => $id_cabang
        ]);

        return redirect('/users')->with('success', 'Akun berhasil ditambahkan!');
    }

    // Menghapus pengguna dengan batasan ketat
    public function destroy($id)
    {
        $user_login = auth()->user();
        $target_user = User::findOrFail($id);

        // Kunci 1: Pusat tidak boleh menghapus/mengedit Kurir seenaknya
        if ($user_login->role === 'admin_pusat' && $target_user->role === 'kurir') {
             return back()->with('error', 'Ditolak! Pusat hanya bisa melihat data Kurir. Penghapusan adalah wewenang Admin Cabang.');
        }

        // Kunci 2: Cabang hanya boleh menghapus Kurir dari cabangnya sendiri
        if ($user_login->role === 'admin_cabang') {
            if ($target_user->role !== 'kurir' || $target_user->id_cabang !== $user_login->id_cabang) {
                return back()->with('error', 'Akses ilegal ke cabang lain!');
            }
        }

        $target_user->delete();
        return back()->with('success', 'Akun berhasil dihapus!');
    }
}