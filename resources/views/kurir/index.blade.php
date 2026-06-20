@extends('layouts.app')

@section('title', 'Manajemen Kurir - ngirim.id')

@section('content')
<div class="container py-5">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h2 class="fw-bold mb-0 text-dark"><i class="bi bi-person-badge text-primary me-2"></i> Manajemen Kurir</h2>
            <p class="text-muted">Kelola data petugas kurir pengiriman ngirim.id di sini.</p>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="/kurir/create" class="btn btn-primary shadow-sm fw-bold">
                <i class="bi bi-plus-circle me-1"></i> Tambah Kurir Baru
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle text-center mb-0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="py-3">ID Kurir</th>
                            <th class="py-3">Nama Kurir</th>
                            <th class="py-3">Nomor HP</th>
                            <th class="py-3">Penempatan Cabang</th>
                            <th class="py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data_kurir as $kurir)
                            <tr>
                                <td class="fw-semibold">#{{ $kurir->id_kurir }}</td>
                                <td class="fw-bold text-dark">{{ $kurir->nama }}</td>
                                <td>
                                    <a href="https://wa.me/{{ $kurir->no_hp }}" target="_blank" class="text-decoration-none text-success fw-semibold">
                                        <i class="bi bi-whatsapp"></i> {{ $kurir->no_hp }}
                                    </a>
                                </td>
                                <td>
                                    <span class="badge bg-info text-dark">{{ $kurir->cabang->nama_cabang }}</span>
                                    <br><small class="text-muted">{{ $kurir->cabang->kota }}</small>
                                </td>
                                <td>
                                    <a href="/kurir/{{ $kurir->id_kurir }}/edit" class="btn btn-sm btn-warning me-1" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form action="/kurir/{{ $kurir->id_kurir }}" method="POST" class="d-inline" id="delete-form-{{ $kurir->id_kurir }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger" title="Hapus" onclick="confirmDelete({{ $kurir->id_kurir }})">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-5 text-muted">
                                    <i class="bi bi-person-x fs-1 d-block mb-2"></i>
                                    Belum ada data kurir yang terdaftar.<br>Silakan klik <b>"Tambah Kurir Baru"</b>.
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
    // Notifikasi Sukses Tambah/Edit Data
    @if(session('success'))
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            });
        });
    @endif

    // Konfirmasi Hapus Data
    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Kurir?',
            text: "Data kurir ini akan dihapus dari sistem!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0d6efd',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Ya, Pecat!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
@endsection