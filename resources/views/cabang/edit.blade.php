@extends('layouts.app')

@section('title', 'Edit Cabang - ngirim.id')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-warning text-dark rounded-top-4 py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i>Edit Data Cabang</h5>
                </div>
                
                <div class="card-body p-4">
                    <form action="/cabang/{{ $cabang->id_cabang }}" method="POST">
                        @csrf 
                        @method('PUT') <div class="mb-3">
                            <label class="form-label fw-bold">Nama Cabang</label>
                            <input type="text" name="nama_cabang" class="form-control" value="{{ $cabang->nama_cabang }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Kota</label>
                            <input type="text" name="kota" class="form-control" value="{{ $cabang->kota }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="3" required>{{ $cabang->alamat }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="/cabang" class="btn btn-outline-secondary px-4">Batal</a>
                            <button type="submit" class="btn btn-warning px-4 fw-bold">Update Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection