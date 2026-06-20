@extends('layouts.app')

@section('title', 'Tambah Cabang Baru - ngirim.id')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-primary text-white rounded-top-4 py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-plus-circle me-2"></i>Tambah Data Cabang</h5>
                </div>
                
                <div class="card-body p-4">
                    <form action="/cabang" method="POST">
                        @csrf <div class="mb-3">
                            <label class="form-label fw-bold">Nama Cabang</label>
                            <input type="text" name="nama_cabang" class="form-control" placeholder="Contoh: Cabang Jakarta Selatan" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Kota</label>
                            <input type="text" name="kota" class="form-control" placeholder="Contoh: Jakarta" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat lengkap..." required></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="/cabang" class="btn btn-outline-secondary px-4">Batal</a>
                            <button type="submit" class="btn btn-primary px-4 fw-bold">Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection