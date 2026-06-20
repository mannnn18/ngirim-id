@extends('layouts.app')

@section('title', 'Dashboard Admin - ngirim.id')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold text-dark"><i class="bi bi-speedometer2 text-primary me-2"></i> Ruang Kendali (Dashboard)</h2>
            <p class="text-muted">Selamat datang, Admin! Berikut adalah ringkasan operasional ngirim.id hari ini.</p>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-primary text-white h-100">
                <div class="card-body p-4 text-center">
                    <i class="bi bi-box-seam fs-1 d-block mb-2 opacity-75"></i>
                    <h2 class="fw-bold mb-0">{{ $total_paket }}</h2>
                    <span class="fs-6">Total Resi Dibuat</span>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-success text-white h-100">
                <div class="card-body p-4 text-center">
                    <i class="bi bi-wallet2 fs-1 d-block mb-2 opacity-75"></i>
                    <h2 class="fw-bold mb-0">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</h2>
                    <span class="fs-6">Total Pendapatan</span>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-warning text-dark h-100">
                <div class="card-body p-4 text-center">
                    <i class="bi bi-truck fs-1 d-block mb-2 opacity-75"></i>
                    <h2 class="fw-bold mb-0">{{ $paket_aktif }}</h2>
                    <span class="fs-6">Paket Sedang Proses/Jalan</span>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-info text-dark h-100">
                <div class="card-body p-4 text-center">
                    <i class="bi bi-people fs-1 d-block mb-2 opacity-75"></i>
                    <h2 class="fw-bold mb-0">{{ $total_kurir }}</h2>
                    <span class="fs-6">Kurir Terdaftar</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-clock-history me-2"></i> 5 Transaksi Terbaru</h5>
                    <a href="/paket" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 text-center">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-3">No. Resi</th>
                                    <th>Pengirim</th>
                                    <th>Penerima</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($paket_terbaru as $paket)
                                    <tr>
                                        <td class="fw-bold font-monospace text-primary">{{ $paket->resi }}</td>
                                        <td>{{ $paket->pengirim->nama }}</td>
                                        <td>{{ $paket->penerima->nama }}</td>
                                        <td>
                                            <span class="badge rounded-pill bg-dark">{{ $paket->status }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-4 text-muted fst-italic">Belum ada transaksi paket.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection