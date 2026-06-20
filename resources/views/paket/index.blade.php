@extends('layouts.app')

@section('title', 'Daftar Paket - ngirim.id')

@section('content')
<div class="container py-5">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h2 class="fw-bold mb-0 text-dark"><i class="bi bi-box-seam text-primary me-2"></i> Transaksi Paket</h2>
            <p class="text-muted">Pantau dan kelola semua kiriman pelanggan ngirim.id.</p>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="/paket/create" class="btn btn-primary shadow-sm fw-bold">
                <i class="bi bi-plus-lg me-1"></i> Input Paket Baru
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle text-center mb-0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="py-3">No. Resi</th>
                            <th class="py-3">Pengirim & Penerima</th>
                            <th class="py-3">Detail & Pembayaran</th> <th class="py-3">Status Pengiriman</th>
                            <th class="py-3">Aksi</th> </tr>
                    </thead>
                    <tbody>
                        @forelse ($data_paket as $paket)
                            <tr>
                                <td>
                                    <span class="badge bg-dark font-monospace p-2 fs-6">{{ $paket->resi }}</span>
                                </td>
                                <td class="text-start">
                                    <div class="mb-1"><i class="bi bi-arrow-up-circle text-success me-1"></i> <b>{{ $paket->pengirim->nama ?? 'Unknown' }}</b></div>
                                    <div><i class="bi bi-arrow-down-circle text-danger me-1"></i> {{ $paket->penerima->nama ?? 'Unknown' }}</div>
                                    <small class="d-block text-muted mt-1"><i class="bi bi-geo-alt-fill me-1"></i> Tujuan: <b>{{ $paket->cabangTujuan->nama_cabang ?? 'Pusat' }}</b></small>
                                </td>
                                <td class="text-start">
                                    <small class="d-block text-muted mb-1">Isi: {{ $paket->isi_paket }} ({{ $paket->berat }} Kg)</small>
                                    
                                    <span class="d-block fw-bold text-success" style="font-size: 1.1rem;">Rp {{ number_format($paket->harga, 0, ',', '.') }}</span>
                                    <span class="badge bg-success mt-1"><i class="bi bi-check-circle me-1"></i> {{ $paket->metode_pembayaran }} - {{ $paket->status_pembayaran }}</span>
                                </td>
                                <td>
                                    <span class="badge rounded-pill bg-warning text-dark px-3 py-2">{{ $paket->status }}</span>
                                </td>
                                <td>
                                    <a href="/paket/resi/{{ $paket->id_paket }}" target="_blank" class="btn btn-dark fw-bold shadow-sm" title="Cetak Label Resi Thermal">
                                        <i class="bi bi-printer-fill me-1"></i> Print Resi
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-5 text-muted">
                                    <i class="bi bi-boxes fs-1 d-block mb-2"></i>
                                    Belum ada transaksi paket hari ini.
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
    // Fitur SweetAlert bawaan Anda tetap dipertahankan untuk notifikasi sukses
    @if(session('success'))
        Swal.fire({ 
            icon: 'success', 
            title: 'Berhasil!', 
            text: "{{ session('success') }}", 
            timer: 3000, 
            showConfirmButton: false 
        });
    @endif
</script>
@endsection