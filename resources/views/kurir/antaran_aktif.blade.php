@extends('layouts.app')
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0"><i class="bi bi-bicycle text-primary me-2"></i> Paket Sedang Diantar</h3>
    </div>

    @if(session('success'))
        <div class="alert alert-success fw-bold"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>
    @endif

    <div class="row g-4">
        @forelse($paket_aktif as $p)
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Sedang Diantar</span>
                        <span class="fw-bold text-muted">{{ $p->resi }}</span>
                    </div>
                    
                    <h5 class="fw-bold mt-3 mb-1">{{ $p->penerima->nama }}</h5>
                    <p class="text-muted small mb-3">
                        <i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $p->penerima->alamat }}<br>
                        <i class="bi bi-telephone-fill text-success me-1"></i> {{ $p->penerima->no_hp }}
                    </p>

                    <hr>

                    <form action="/kurir/selesaikan/{{ $p->id_paket }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Diterima Oleh (Nama Asli):</label>
                            <input type="text" name="nama_penerima_asli" class="form-control form-control-sm" placeholder="Cth: Budi / Satpam / Tetangga" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Foto Bukti Pengiriman:</label>
                            <input type="file" name="foto_bukti" class="form-control form-control-sm" accept="image/*" capture="environment" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100 fw-bold shadow-sm">
                            <i class="bi bi-check2-all me-1"></i> SELESAIKAN ANTARAN
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="bi bi-box-seam fs-1 text-muted opacity-25"></i>
            <p class="text-muted mt-3">Tidak ada paket yang sedang Anda antar saat ini.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection