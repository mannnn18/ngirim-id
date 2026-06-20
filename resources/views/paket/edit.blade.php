@extends('layouts.app')

@section('title', 'Kelola Transaksi & Tracking - ngirim.id')

@section('content')
<div class="container py-5">
    <div class="row g-4">
        
        <div class="col-md-5">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-box-seam me-2"></i> Detail Transaksi</h5>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-light border shadow-sm text-center mb-4">
                        <span class="text-muted d-block mb-1">Nomor Resi:</span>
                        <h4 class="fw-bold font-monospace text-primary mb-0">{{ $paket->resi }}</h4>
                    </div>

                    <form action="/paket/{{ $paket->id_paket }}" method="POST">
                        @csrf @method('PUT')
                        <div class="mb-3">
                            <label class="form-label fw-bold">Isi / Deskripsi Barang</label>
                            <textarea name="isi_paket" class="form-control" rows="2" required>{{ $paket->isi_paket }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Status Utama Paket</label>
                            <select name="status" class="form-select shadow-sm" required>
                                <option value="Menunggu Pickup" {{ $paket->status == 'Menunggu Pickup' ? 'selected' : '' }}>Menunggu Pickup</option>
                                <option value="Sedang Diproses" {{ $paket->status == 'Sedang Diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                                <option value="Dalam Perjalanan" {{ $paket->status == 'Dalam Perjalanan' ? 'selected' : '' }}>Dalam Perjalanan</option>
                                <option value="Tiba di Tujuan" {{ $paket->status == 'Tiba di Tujuan' ? 'selected' : '' }}>Tiba di Tujuan</option>
                                <option value="Selesai Diambil" {{ $paket->status == 'Selesai Diambil' ? 'selected' : '' }}>Selesai Diambil</option>
                            </select>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-warning fw-bold">Update Status Utama</button>
                        </div>
                    </form>
                </div>
            </div>
            <a href="/paket" class="btn btn-outline-secondary w-100"><i class="bi bi-arrow-left"></i> Kembali ke Daftar Paket</a>
        </div>

        <div class="col-md-7">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-dark text-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-geo-alt me-2"></i> Update Posisi Paket (Tracking)</h5>
                </div>
                <div class="card-body p-4">
                    
                    <form action="/tracking" method="POST" class="mb-4 border-bottom pb-4">
                        @csrf
                        <input type="hidden" name="id_paket" value="{{ $paket->id_paket }}">
                        
                        <div class="row">
                            <div class="col-md-5 mb-3">
                                <label class="form-label fw-semibold">Lokasi Saat Ini</label>
                                <input type="text" name="lokasi" class="form-control" placeholder="Cth: Hub Jakarta" required>
                            </div>
                            <div class="col-md-5 mb-3">
                                <label class="form-label fw-semibold">Keterangan / Status</label>
                                <input type="text" name="status" class="form-control" placeholder="Cth: Paket telah diberangkatkan" required>
                            </div>
                            <div class="col-md-2 mb-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-success w-100"><i class="bi bi-send-plus"></i></button>
                            </div>
                        </div>
                    </form>

                    <h6 class="fw-bold text-muted mb-3">Riwayat Perjalanan Terakhir:</h6>
                    <div class="timeline ps-3" style="border-left: 3px solid #0d6efd;">
                        @forelse ($paket->tracking as $track)
                            <div class="position-relative mb-3 ps-3">
                                <span class="position-absolute top-0 start-0 translate-middle bg-primary border border-white border-3 rounded-circle" style="width: 16px; height: 16px; margin-left: -1.5px;"></span>
                                
                                <div class="fw-bold text-dark">{{ $track->lokasi }}</div>
                                <div class="text-muted small mb-1"><i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($track->waktu)->format('d M Y, H:i') }} WIB</div>
                                <div class="text-secondary">{{ $track->status }}</div>
                            </div>
                        @empty
                            <div class="text-muted fst-italic">Belum ada riwayat perjalanan untuk paket ini.</div>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<script>
    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", timer: 2000, showConfirmButton: false });
    @endif
</script>
@endsection