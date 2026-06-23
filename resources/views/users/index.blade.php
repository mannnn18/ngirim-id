@extends('layouts.app')
@section('title', 'Manajemen Pengguna - ngirim.id')

@section('content')
<div class="container py-4">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h2 class="fw-bold mb-0">
                <i class="bi bi-people text-primary me-2"></i> 
                Manajemen {{ auth()->user()->role === 'admin_pusat' ? 'Admin Cabang' : 'Kurir' }}
            </h2>
            <p class="text-muted">Pusat kendali akun operasional sistem.</p>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="/users/create" class="btn btn-primary shadow-sm fw-bold">
                <i class="bi bi-plus-lg me-1"></i> 
                Tambah {{ auth()->user()->role === 'admin_pusat' ? 'Admin Cabang' : 'Kurir Baru' }}
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0 text-center">
                <thead class="bg-primary text-white">
                    <tr>
                        <th class="py-3">Nama Lengkap</th>
                        <th>Email / Login</th>
                        <th>Peran (Role)</th>
                        <th>Asal Cabang</th>
                        <th class="py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $u)
                        <tr>
                            <td class="text-start fw-bold ps-4">{{ $u->nama }}</td>
                            <td>{{ $u->email }}</td>
                            <td>
                                @if($u->role === 'admin_cabang')
                                    <span class="badge bg-warning text-dark">Admin Cabang</span>
                                @else
                                    <span class="badge bg-success">Kurir</span>
                                @endif
                            </td>
                            <td>{{ $u->cabang->nama_cabang ?? 'Pusat' }}</td>
                            <td>
                                @if(auth()->user()->role === 'admin_pusat' && $u->role === 'kurir')
                                    <span class="text-muted small"><i class="bi bi-lock me-1"></i>Read Only</span>
                                @else
                                    <a href="/users/{{ $u->id_user }}/edit" class="btn btn-sm btn-warning me-1" title="Edit Akun">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    
                                    <form action="/users/{{ $u->id_user }}" method="POST" class="d-inline" id="delete-form-{{ $u->id_user }}">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $u->id_user }})" title="Hapus Akun">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="py-5 text-muted">Belum ada akun yang didaftarkan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    @if(session('success'))
        Swal.fire({ 
            icon: 'success', 
            title: 'Berhasil!', 
            text: "{{ session('success') }}", 
            timer: 3000, 
            showConfirmButton: false 
        });
    @endif

    @if(session('error'))
        Swal.fire({ 
            icon: 'error', 
            title: 'Gagal!', 
            text: "{{ session('error') }}", 
            timer: 3000, 
            showConfirmButton: false 
        });
    @endif

    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Pengguna?',
            text: "Akun ini akan dihapus secara permanen dari sistem!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) { 
                document.getElementById('delete-form-' + id).submit(); 
            }
        })
    }
</script>
@endsection