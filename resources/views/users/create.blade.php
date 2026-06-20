@extends('layouts.app')
@section('title', 'Tambah Pengguna - ngirim.id')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-person-plus me-2"></i> Pendaftaran Akun Operasional</h5>
                </div>
                <div class="card-body p-4">
                    <form action="/users" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Email Akses</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Nomor HP</label>
                                <input type="number" name="no_hp" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Password Sementara</label>
                                <input type="text" name="password" class="form-control" placeholder="Minimal 6 huruf/angka" required>
                            </div>
                        </div>

                        @if($user_login->role === 'admin_pusat')
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-primary">Tugaskan Sebagai Admin di Cabang:</label>
                                <select name="id_cabang" class="form-select bg-light" required>
                                    <option value="">-- Pilih Cabang --</option>
                                    @foreach($data_cabang as $c)
                                        <option value="{{ $c->id_cabang }}">{{ $c->nama_cabang }} ({{ $c->kota }})</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <div class="alert alert-info py-2 small">
                                <i class="bi bi-info-circle me-1"></i> Akun yang dibuat otomatis akan menjadi <b>Kurir</b> untuk cabang Anda.
                            </div>
                        @endif

                        <div class="mb-4">
                            <label class="form-label fw-bold small">Alamat Domisili</label>
                            <textarea name="alamat" class="form-control" rows="2" required></textarea>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="/users" class="btn btn-outline-secondary px-4 fw-bold">Batal</a>
                            <button type="submit" class="btn btn-primary px-4 fw-bold">Buat Akun</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection