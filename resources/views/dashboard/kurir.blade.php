@extends('layouts.app')
@section('content')
<div class="container py-4">
    <div class="row align-items-center mb-4">
        <div class="col-md-8">
            <h3 class="fw-bold text-dark mb-0">Halo, {{ auth()->user()->nama }}! 🚚</h3>
            <p class="text-muted">Semangat bekerja! Pantau performa dan komisi harianmu di sini.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-primary text-white h-100">
                <div class="card-body p-4 text-center">
                    <i class="bi bi-box-seam fs-1 opacity-50 mb-2 d-block"></i>
                    <h6 class="fw-bold text-uppercase tracking-wider">Total Paket Selesai</h6>
                    <h1 class="fw-bold display-4 mb-0">{{ $total_selesai }}</h1>
                    <p class="mb-0 mt-2 small opacity-75">Paket berhasil diantar ke pelanggan</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-success text-white h-100">
                <div class="card-body p-4 text-center">
                    <i class="bi bi-wallet2 fs-1 opacity-50 mb-2 d-block"></i>
                    <h6 class="fw-bold text-uppercase tracking-wider">Estimasi Komisi (Rp 500/Paket)</h6>
                    <h1 class="fw-bold display-4 mb-0">Rp {{ number_format($total_komisi, 0, ',', '.') }}</h1>
                    <p class="mb-0 mt-2 small opacity-75">Terus tingkatkan antaranmu!</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection