@extends('layouts.app')

@section('title', 'Pusat Laporan - ngirim.id')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-file-earmark-bar-graph me-2"></i> Tarik Laporan</h5>
                </div>
                <div class="card-body p-4">
                    <form action="/laporan/generate" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Dari Tanggal</label>
                            <input type="date" name="tgl_mulai" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Sampai Tanggal</label>
                            <input type="date" name="tgl_selesai" class="form-control" required>
                        </div>

                        @if(auth()->user()->role === 'admin_pusat')
                        <div class="mb-4">
                            <label class="form-label fw-bold">Filter Cabang (Opsional)</label>
                            <select name="id_cabang" class="form-select">
                                <option value="">-- Semua Cabang --</option>
                                @foreach($data_cabang as $c)
                                    <option value="{{ $c->id_cabang }}">{{ $c->nama_cabang }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Kosongkan untuk melihat laporan nasional.</small>
                        </div>
                        @endif

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold shadow">
                                <i class="bi bi-printer me-1"></i> Tampilkan Laporan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection