@extends('layouts.app')

@section('title', 'Manajemen Cabang - ngirim.id')

@section('content')
<div class="container py-4">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h2 class="fw-bold mb-0 text-dark"><i class="bi bi-buildings text-primary me-2"></i> Manajemen Cabang</h2>
            <p class="text-muted">Kelola seluruh kantor cabang operasional ngirim.id di berbagai kota.</p>
        </div>
        
        <div class="col-md-6 text-md-end">
            @if(auth()->user()->role === 'admin_pusat')
                <a href="/cabang/create" class="btn btn-primary shadow-sm fw-bold">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Cabang
                </a>
            @endif
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle mb-0 text-center">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="py-3">ID Cabang</th>
                            <th class="py-3 text-start">Nama Cabang</th>
                            <th class="py-3">Kota</th>
                            <th class="py-3">Kontak</th>
                            
                            @if(auth()->user()->role === 'admin_pusat')
                                <th class="py-3">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data_cabang as $cabang)
                            <tr>
                                <td><span class="badge bg-secondary">CBG-{{ str_pad($cabang->id_cabang, 3, '0', STR_PAD_LEFT) }}</span></td>
                                <td class="text-start fw-bold text-dark">{{ $cabang->nama_cabang }}</td>
                                <td>{{ $cabang->kota }}</td>
                                <td>
                                    <div class="small"><i class="bi bi-telephone text-success me-1"></i> {{ $cabang->no_telp }}</div>
                                    <div class="small text-muted text-truncate" style="max-width: 200px;" title="{{ $cabang->alamat }}">{{ $cabang->alamat }}</div>
                                </td>
                                
                                @if(auth()->user()->role === 'admin_pusat')
                                    <td>
                                        <a href="/cabang/{{ $cabang->id_cabang }}/edit" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="/cabang/{{ $cabang->id_cabang }}" method="POST" class="d-inline" id="delete-form-{{ $cabang->id_cabang }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $cabang->id_cabang }})" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ auth()->user()->role === 'admin_pusat' ? '5' : '4' }}" class="py-5 text-muted">
                                    Belum ada data cabang yang didaftarkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", timer: 3000, showConfirmButton: false });
    @endif
    @if(session('error'))
        Swal.fire({ icon: 'error', title: 'Akses Ditolak!', text: "{{ session('error') }}", timer: 3000, showConfirmButton: false });
    @endif

    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Cabang?',
            text: "Semua data kurir yang terikat dengan cabang ini mungkin akan ikut bermasalah!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) { document.getElementById('delete-form-' + id).submit(); }
        })
    }
</script>
@endsection