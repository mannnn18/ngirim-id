@extends('layouts.app')

@section('title', 'Hasil Laporan - ngirim.id')

@section('content')
<div class="container py-4">
    <div class="row mb-4 align-items-center d-print-none">
        <div class="col-md-6">
            <h2 class="fw-bold mb-0"><i class="bi bi-file-earmark-text text-primary me-2"></i> Laporan Operasional</h2>
            <p class="text-muted">Periode: <b>{{ date('d M Y', strtotime($tgl_mulai)) }}</b> s/d <b>{{ date('d M Y', strtotime($tgl_selesai)) }}</b></p>
        </div>
        <div class="col-md-6 text-md-end">
            <button onclick="window.print()" class="btn btn-dark shadow-sm fw-bold">
                <i class="bi bi-printer me-1"></i> Cetak Laporan (PDF)
            </button>
            <a href="/laporan" class="btn btn-outline-secondary shadow-sm fw-bold ms-2">Kembali</a>
        </div>
    </div>

    <div class="d-none d-print-block text-center mb-5">
        <h1 class="fw-bold">LAPORAN OPERASIONAL & KEUANGAN NGIRIM.ID</h1>
        <p>Periode: {{ date('d F Y', strtotime($tgl_mulai)) }} - {{ date('d F Y', strtotime($tgl_selesai)) }}</p>
        <hr border="2">
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-primary text-white">
                <div class="card-body p-4 text-center">
                    <h6 class="text-uppercase small fw-bold opacity-75">Total Pendapatan</h6>
                    <h2 class="fw-bold mb-0">Rp {{ number_format($laporan_keuangan->sum('paket.harga'), 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-success text-white">
                <div class="card-body p-4 text-center">
                    <h6 class="text-uppercase small fw-bold opacity-75">Total Paket Masuk</h6>
                    <h2 class="fw-bold mb-0">{{ $total_paket }} Paket</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-dark text-white">
                <div class="card-body p-4 text-center">
                    <h6 class="text-uppercase small fw-bold opacity-75">Status Paket</h6>
                    <div class="d-flex justify-content-around mt-2">
                        @foreach($status_counts as $s)
                            <div class="text-center">
                                <span class="d-block fw-bold fs-4">{{ $s->total }}</span>
                                <small class="opacity-75">{{ $s->status }}</small>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-list-check me-2"></i> Rincian Transaksi Keuangan</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3">Tanggal</th>
                            <th>No. Resi</th>
                            <th>Keterangan Paket</th>
                            <th>Berat</th>
                            <th class="text-end px-4">Biaya (Omzet)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporan_keuangan as $item)
                        <tr>
                            <td>{{ date('d/m/Y', strtotime($item->tanggal_kirim)) }}</td>
                            <td class="fw-bold font-monospace">{{ $item->paket->resi }}</td>
                            <td class="text-start">
                                <small class="d-block">{{ $item->paket->isi_paket }}</small>
                                <span class="badge bg-secondary small">{{ $item->asal }} <i class="bi bi-arrow-right mx-1"></i> {{ $item->tujuan }}</span>
                            </td>
                            <td>{{ $item->paket->berat }} Kg</td>
                            <td class="text-end fw-bold px-4 text-success">Rp {{ number_format($item->paket->harga, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-5 text-muted">Tidak ada data transaksi ditemukan pada periode ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="table-light fw-bold">
                        <tr>
                            <td colspan="4" class="text-end py-3">GRAND TOTAL PENDAPATAN:</td>
                            <td class="text-end px-4 text-primary fs-5">Rp {{ number_format($laporan_keuangan->sum('paket.harga'), 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4 d-none d-print-block">
        <div class="row">
            <div class="col-8"></div>
            <div class="col-4 text-center">
                <p>Dicetak pada: {{ date('d/m/Y H:i') }}</p>
                <br><br><br>
                <p class="fw-bold border-top pt-2">{{ auth()->user()->nama }}</p>
                <p class="small text-muted text-uppercase">{{ auth()->user()->role }}</p>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .main-content { margin-left: 0 !important; width: 100% !important; padding: 0 !important; }
        .sidebar, .topbar { display: none !important; }
        .card { box-shadow: none !important; border: 1px solid #ddd !important; }
    }
</style>
@endsection