<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lacak Resi - ngirim.id</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', sans-serif; }
        .hero-section {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            color: white;
            padding: 60px 0 80px;
            text-align: center;
            border-bottom-left-radius: 50px;
            border-bottom-right-radius: 50px;
        }
        .search-box {
            max-width: 600px;
            margin: -40px auto 0;
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .timeline {
            position: relative;
            padding: 20px 0;
            list-style: none;
        }
        .timeline::before {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            left: 20px;
            width: 4px;
            background: #e9ecef;
            border-radius: 4px;
        }
        .timeline-item {
            position: relative;
            margin-bottom: 30px;
            padding-left: 50px;
        }
        .timeline-icon {
            position: absolute;
            left: 8px;
            top: 0;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #fff;
            border: 4px solid #0d6efd;
            z-index: 1;
        }
        .timeline-item:first-child .timeline-icon {
            background: #0d6efd;
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.2);
        }
    </style>
</head>
<body>

    <div class="hero-section">
        <div class="container">
            <h1 class="fw-bold"><i class="bi bi-box-seam me-2"></i>ngirim.id</h1>
            <p class="lead opacity-75">Pantau paket Anda dengan mudah dan cepat</p>
        </div>
    </div>

    <div class="container">
        <div class="search-box">
            <form action="/lacak" method="GET" class="d-flex gap-2">
                <input type="text" name="resi" class="form-control form-control-lg bg-light" 
                       placeholder="Masukkan Nomor Resi Anda..." 
                       value="{{ request('resi') }}" required style="text-transform: uppercase;">
                <button type="submit" class="btn btn-primary btn-lg px-4 fw-bold">CARI</button>
            </form>
        </div>

        @if(request('resi'))
            @if($paket)
            <div class="row justify-content-center mt-5 mb-5">
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold text-primary mb-0">Resi: {{ $paket->resi }}</h5>
                                <span class="badge bg-warning text-dark fs-6">{{ $paket->status }}</span>
                            </div>
                            <div class="row text-muted small">
                                <div class="col-6">
                                    <p class="mb-1"><b>Pengirim:</b> {{ $paket->pengirim->nama }}</p>
                                    <p class="mb-0"><b>Isi:</b> {{ $paket->isi_paket }}</p>
                                </div>
                                <div class="col-6 text-end">
                                    <p class="mb-0"><b>Penerima:</b> {{ $paket->penerima->nama }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-4 border-bottom pb-2">Riwayat Pengiriman</h6>
                            
                            @if($paket->tracking->count() > 0)
                                <ul class="timeline">
                                    @foreach($paket->tracking as $riwayat)
                                        <li class="timeline-item">
                                            <div class="timeline-icon"></div>
                                            <div class="small text-muted mb-1">{{ \Carbon\Carbon::parse($riwayat->waktu)->format('d M Y, H:i') }} WIB</div>
                                            <div class="fw-bold text-dark">{{ $riwayat->status }}</div>
                                            <div class="text-muted small">Posisi: {{ $riwayat->lokasi }}</div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-center text-muted">Belum ada riwayat perjalanan paket.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @else
                <div class="row justify-content-center mt-5">
                    <div class="col-md-6 text-center">
                        <img src="https://cdn-icons-png.flaticon.com/512/7486/7486747.png" alt="Not Found" width="120" class="mb-3 opacity-50">
                        <h4 class="fw-bold text-dark">Resi Tidak Ditemukan</h4>
                        <p class="text-muted">Maaf, nomor resi <b>{{ request('resi') }}</b> tidak terdaftar di sistem kami.</p>
                    </div>
                </div>
            @endif
        @endif
    </div>

</body>
</html>