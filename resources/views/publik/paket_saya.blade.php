<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paket Saya - ngirim.id</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <nav class="navbar navbar-light bg-white shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="/"><i class="bi bi-box-seam-fill me-2"></i>ngirim.id</a>
            <a href="/" class="btn btn-outline-secondary btn-sm rounded-pill px-3">Kembali ke Beranda</a>
        </div>
    </nav>

    <div class="container py-4">
        <h3 class="fw-bold mb-4">Daftar Paket Saya</h3>

        <div class="row g-3">
            @forelse($paket_saya as $p)
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 mb-3">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h6 class="text-muted small mb-1">NOMOR RESI</h6>
                                <h5 class="fw-bold text-primary font-monospace">{{ $p->resi }}</h5>
                            </div>
                            <span class="badge bg-primary px-3 py-2 rounded-pill">{{ $p->status }}</span>
                        </div>
                        <div class="row small text-muted">
                            <div class="col-6">
                                <p class="mb-1">Penerima: <b>{{ $p->penerima->nama }}</b></p>
                                <p class="mb-0">Isi: {{ $p->isi_paket }}</p>
                            </div>
                            <div class="col-6 text-end align-self-end">
                                <form action="/lacak" method="GET">
                                    <input type="hidden" name="resi" value="{{ $p->resi }}">
                                    <button type="submit" class="btn btn-sm btn-dark px-3 rounded-pill">Detail Tracking</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-5">
                <i class="bi bi-box2 fs-1 text-muted opacity-25"></i>
                <p class="text-muted mt-3">Anda belum memiliki riwayat pengiriman paket.</p>
            </div>
            @endforelse
        </div>
    </div>
</body>
</html>