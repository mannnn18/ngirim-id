@extends('layouts.app')

@section('title', 'Manajemen Tarif - ngirim.id')

@section('content')
<div class="container py-5">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h2 class="fw-bold mb-0 text-dark"><i class="bi bi-tags text-primary me-2"></i> Manajemen Tarif Ongkir</h2>
            <p class="text-muted">Kelola harga pengiriman antar kota ngirim.id di sini.</p>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="/tarif/create" class="btn btn-primary shadow-sm fw-bold">
                <i class="bi bi-plus-circle me-1"></i> Tambah Tarif Baru
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle text-center mb-0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="py-3">Rute Pengiriman</th>
                            <th class="py-3">Harga / Kg</th>
                            <th class="py-3">Estimasi Tiba</th>
                            <th class="py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data_tarif as $tarif)
                            <tr>
                                <td class="fw-bold text-dark text-start ps-4">
                                    {{ $tarif->kota_asal }} <i class="bi bi-arrow-right text-primary mx-2"></i> {{ $tarif->kota_tujuan }}
                                </td>
                                <td class="fw-semibold text-success">
                                    Rp {{ number_format($tarif->harga_per_kg, 0, ',', '.') }}
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border"><i class="bi bi-clock me-1"></i> {{ $tarif->estimasi_hari }} Hari</span>
                                </td>
                                <td>
                                    <a href="/tarif/{{ $tarif->id_tarif }}/edit" class="btn btn-sm btn-warning me-1" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="/tarif/{{ $tarif->id_tarif }}" method="POST" class="d-inline" id="delete-form-{{ $tarif->id_tarif }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger" title="Hapus" onclick="confirmDelete({{ $tarif->id_tarif }})">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-5 text-muted">
                                    <i class="bi bi-cash-coin fs-1 d-block mb-2"></i>
                                    Belum ada data tarif ongkir yang terdaftar.<br>Silakan klik <b>"Tambah Tarif Baru"</b>.
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

    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Rute Tarif?',
            text: "Data tarif ongkir ini akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0d6efd',
            cancelButtonColor: '#dc3545',
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