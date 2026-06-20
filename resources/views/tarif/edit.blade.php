@extends('layouts.app')

@section('title', 'Edit Tarif - ngirim.id')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-warning text-dark py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i>Edit Tarif Ongkir</h5>
                </div>
                <div class="card-body p-4">
                    <form action="/tarif/{{ $tarif->id_tarif }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Kota Asal</label>
                                <input type="text" name="kota_asal" class="form-control" value="{{ $tarif->kota_asal }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Kota Tujuan</label>
                                <input type="text" name="kota_tujuan" class="form-control" value="{{ $tarif->kota_tujuan }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Harga per Kg (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="harga_per_kg" class="form-control" value="{{ $tarif->harga_per_kg }}" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">Estimasi Tiba (Hari)</label>
                                <div class="input-group">
                                    <input type="number" name="estimasi_hari" class="form-control" value="{{ $tarif->estimasi_hari }}" required>
                                    <span class="input-group-text">Hari</span>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="/tarif" class="btn btn-outline-secondary px-4">Batal</a>
                            <button type="submit" class="btn btn-warning px-4 fw-bold">Update Tarif</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection