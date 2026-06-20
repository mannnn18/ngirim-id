@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-success text-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-calculator me-2"></i> Hitung Biaya & Proses Pengiriman</h5>
                </div>
                <div class="card-body p-4">
                    <form action="/pengiriman" method="POST">
                        @csrf
                        <input type="hidden" name="id_paket" value="{{ $paket->id_paket }}">

                        <div class="alert alert-info border-0 shadow-sm">
                            <h6 class="fw-bold"><i class="bi bi-info-circle"></i> Ringkasan Paket:</h6>
                            <hr>
                            <div class="row">
                                <div class="col-6">Resi: <b>{{ $paket->resi }}</b></div>
                                <div class="col-6">Berat: <b>{{ $paket->berat }} Kg</b></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Pilih Rute & Tarif</label>
                            <select name="id_tarif" class="form-select shadow-sm" required>
                                <option value="">-- Pilih Rute (Asal -> Tujuan) --</option>
                                @foreach($data_tarif as $t)
                                    <option value="{{ $t->id_tarif }}">
                                        {{ $t->kota_asal }} ke {{ $t->kota_tujuan }} (Rp {{ number_format($t->harga_per_kg) }}/Kg)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Tugaskan Kurir Penjemput</label>
                            <select name="id_kurir" class="form-select shadow-sm" required>
                                <option value="">-- Pilih Kurir --</option>
                                @foreach($data_kurir as $k)
                                    <option value="{{ $k->id_kurir }}">{{ $k->nama }} ({{ $k->cabang->nama_cabang }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg fw-bold shadow">
                                <i class="bi bi-check-all"></i> Konfirmasi & Hitung Biaya
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection