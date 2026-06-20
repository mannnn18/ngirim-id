
@section('content')
<div class="container py-5">
    
    <div class="row justify-content-center mb-5">
        <div class="col-md-8 text-center">
            <h2 class="fw-bold mb-3">Lacak Kiriman Anda</h2>
            <p class="text-muted mb-4">Masukkan nomor resi ngirim.id Anda untuk mengetahui posisi paket secara real-time.</p>
            
            <form action="/lacak" method="GET" class="d-flex shadow-sm rounded-pill overflow-hidden bg-white p-1 border">
                <input type="text" name="resi" class="form-control border-0 px-4 py-3 shadow-none" placeholder="Contoh: NGR-20260416-ABCD" value="{{ request('resi') }}" required style="font-size: 1.1rem; text-transform: uppercase;">
                <button type="submit" class="btn btn-primary px-5 rounded-pill fw-bold" style="font-size: 1.1rem;">
                    <i class="bi bi-search me-2"></i> Lacak
                </button>
            </form>
        </div>
    </div>

    @if(request('resi'))
        @if($paket)
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                                <div>
                                    <h6 class="text-muted mb-1">Nomor Resi:</h6>
                                    <h3 class="fw-bold font-monospace text-primary mb-0">{{ $paket->resi }}</h3>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-warning text-dark fs-6 px-3 py-2 rounded-pill">{{ $paket->status }}</span>
                                </div>
                            </div>
                            
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <h6 class="text-muted mb-1"><i class="bi bi-box me-1"></i> Pengirim:</h6>
                                    <p class="fw-semibold mb-0">{{ $paket->pengirim->nama }}</p>
                                </div>
                                <div class="col-sm-6 text-sm-end">
                                    <h6 class="text-muted mb-1"><i class="bi bi-person-check me-1"></i> Penerima:</h6>
                                    <p class="fw-semibold mb-0">{{ $paket->penerima->nama }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4 p-md-5">
                            <h5 class="fw-bold mb-4"><i class="bi bi-signpost-split text-primary me-2"></i> Timeline Perjalanan</h5>
                            
                            @if($paket->tracking->count() > 0)
                                <div class="timeline ps-3" style="border-left: 3px solid #0d6efd;">
                                    @foreach ($paket->tracking as $track)
                                        <div class="position-relative mb-4 ps-4">
                                            <span class="position-absolute top-0 start-0 translate-middle {{ $loop->first ? 'bg-warning border-primary' : 'bg-primary border-white' }} border border-3 rounded-circle" style="width: 20px; height: 20px; margin-left: -1.5px;"></span>
                                            
                                            <div class="fw-bold text-dark fs-5">{{ $track->status }}</div>
                                            <div class="text-primary fw-semibold mb-1">{{ $track->lokasi }}</div>
                                            <div class="text-muted small"><i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($track->waktu)->format('d M Y, H:i') }} WIB</div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-warning text-center border-0 shadow-sm mt-3">
                                    <i class="bi bi-info-circle me-2"></i> Paket sedang dipersiapkan dan belum memulai perjalanan.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row justify-content-center">
                <div class="col-md-6 text-center">
                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486747.png" alt="Not Found" width="120" class="mb-3 opacity-50">
                    <h4 class="fw-bold text-dark">Resi Tidak Ditemukan</h4>
                    <p class="text-muted">Pastikan nomor resi ({{ request('resi') }}) yang Anda masukkan sudah benar.</p>
                </div>
            </div>
        @endif
    @endif
</div>
