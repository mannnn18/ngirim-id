<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cabang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user_login = auth()->user();

        if ($user_login->role === 'admin_pusat') {
            $users = User::whereIn('role', ['admin_cabang', 'kurir'])->latest()->get();
        } elseif ($user_login->role === 'admin_cabang') {
            $users = User::where('role', 'kurir')
                         ->where('id_cabang', $user_login->id_cabang)
                         ->latest()->get();
        } else {
            return redirect('/dashboard')->with('error', 'Akses ditolak.');
        }

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $user_login = auth()->user();
        $data_cabang = Cabang::all();

        return view('users.create', compact('user_login', 'data_cabang'));
    }

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

        if ($user_login->role === 'admin_pusat') {
            $request->validate(['id_cabang' => 'required']);
            $role = 'admin_cabang';
            $id_cabang = $request->id_cabang;
        } elseif ($user_login->role === 'admin_cabang') {
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

    // --- TAMBAHAN BARU: Menampilkan Halaman Edit ---
    public function edit($id)
    {
        $user_login = auth()->user();
        $user = User::findOrFail($id);
        $data_cabang = Cabang::all();

        // Keamanan 1: Pusat tidak boleh edit Kurir
        if ($user_login->role === 'admin_pusat' && $user->role === 'kurir') {
             return back()->with('error', 'Ditolak! Pusat hanya bisa melihat data Kurir.');
        }

        // Keamanan 2: Cabang hanya boleh edit Kurirnya sendiri
        if ($user_login->role === 'admin_cabang') {
            if ($user->role !== 'kurir' || $user->id_cabang !== $user_login->id_cabang) {
                return back()->with('error', 'Akses ilegal ke cabang lain!');
            }
        }

        return view('users.edit', compact('user', 'user_login', 'data_cabang'));
    }

    // --- TAMBAHAN BARU: Memproses Perubahan Data ---
    public function update(Request $request, $id)
    {
        $user_login = auth()->user();
        $user = User::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            // Pastikan email unik, TAPI abaikan email milik user ini sendiri
            'email' => 'required|string|email|max:255|unique:users,email,'.$id.',id_user',
            'password' => 'nullable|string|min:6', // Nullable agar tidak wajib ganti password
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string',
        ]);

        $data_update = [
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ];

        // Jika form password diisi, ikut di-update
        if ($request->filled('password')) {
            $data_update['password'] = Hash::make($request->password);
        }

        // Jika yang edit Admin Pusat, update penempatan cabangnya juga
        if ($user_login->role === 'admin_pusat') {
            $request->validate(['id_cabang' => 'required']);
            $data_update['id_cabang'] = $request->id_cabang;
        }

        $user->update($data_update);

        return redirect('/users')->with('success', 'Data akun berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user_login = auth()->user();
        $target_user = User::findOrFail($id);

        if ($user_login->role === 'admin_pusat' && $target_user->role === 'kurir') {
             return back()->with('error', 'Ditolak! Pusat hanya bisa melihat data Kurir. Penghapusan adalah wewenang Admin Cabang.');
        }

        if ($user_login->role === 'admin_cabang') {
            if ($target_user->role !== 'kurir' || $target_user->id_cabang !== $user_login->id_cabang) {
                return back()->with('error', 'Akses ilegal ke cabang lain!');
            }
        }

        $target_user->delete();
        return back()->with('success', 'Akun berhasil dihapus!');
    }
}