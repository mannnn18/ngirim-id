@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold">Tambah Kurir Baru</h5>
                </div>
                <div class="card-body p-4">
                    <form action="/kurir" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Kurir</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nomor HP</label>
                            <input type="text" name="no_hp" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Penempatan Cabang</label>
                            <select name="id_cabang" class="form-select" required>
                                <option value="">-- Pilih Cabang --</option>
                                @foreach($data_cabang as $cabang)
                                    <option value="{{ $cabang->id_cabang }}">{{ $cabang->nama_cabang }} ({{ $cabang->kota }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="/kurir" class="btn btn-outline-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary px-4">Simpan Kurir</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection