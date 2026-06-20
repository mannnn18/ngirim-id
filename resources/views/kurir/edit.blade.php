@extends('layouts.app')

@section('title', 'Edit Kurir - ngirim.id')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-warning text-dark py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i>Edit Data Kurir</h5>
                </div>
                <div class="card-body p-4">
                    <form action="/kurir/{{ $kurir->id_kurir }}" method="POST">
                        @csrf
                        @method('PUT') <div class="mb-3">
                            <label class="form-label fw-bold">Nama Kurir</label>
                            <input type="text" name="nama" class="form-control" value="{{ $kurir->nama }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nomor HP</label>
                            <input type="text" name="no_hp" class="form-control" value="{{ $kurir->no_hp }}" required>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Penempatan Cabang</label>
                            <select name="id_cabang" class="form-select" required>
                                <option value="">-- Pilih Cabang --</option>
                                @foreach($data_cabang as $cabang)
                                    <option value="{{ $cabang->id_cabang }}" {{ $kurir->id_cabang == $cabang->id_cabang ? 'selected' : '' }}>
                                        {{ $cabang->nama_cabang }} ({{ $cabang->kota }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="/kurir" class="btn btn-outline-secondary px-4">Batal</a>
                            <button type="submit" class="btn btn-warning px-4 fw-bold">Update Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection