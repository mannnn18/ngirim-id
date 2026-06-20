@extends('layouts.app')

@section('title', 'Tambah Tarif Baru - ngirim.id')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-plus-circle me-2"></i>Tambah Tarif Ongkir</h5>
                </div>
                <div class="card-body p-4">
                    <form action="/tarif" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Kota Asal (Cabang)</label>
                                <select name="kota_asal" class="form-select border-primary" required>
                                    <option value="">-- Pilih Kota Asal --</option>
                                    @foreach($data_cabang as $cabang)
                                        <option value="{{ $cabang->kota }}">{{ $cabang->nama_cabang }} ({{ $cabang->kota }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Kota Tujuan (Cabang)</label>
                                <select name="kota_tujuan" class="form-select border-danger" required>
                                    <option value="">-- Pilih Kota Tujuan --</option>
                                    @foreach($data_cabang as $cabang)
                                        <option value="{{ $cabang->kota }}">{{ $cabang->nama_cabang }} ({{ $cabang->kota }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Harga per Kg (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="harga_per_kg" class="form-control" placeholder="Contoh: 15000" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">Estimasi Tiba (Hari)</label>
                                <div class="input-group">
                                    <input type="number" name="estimasi_hari" class="form-control" placeholder="Contoh: 3" required>
                                    <span class="input-group-text">Hari</span>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="/tarif" class="btn btn-outline-secondary px-4">Batal</a>
                            <button type="submit" class="btn btn-primary px-4 fw-bold">Simpan Tarif</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection