@extends('layouts.app')
@section('title', 'Edit Pengguna - ngirim.id')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-warning text-dark py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i> Perbarui Data Akun Operasional</h5>
                </div>
                <div class="card-body p-4">
                    <form action="/users/{{ $user->id_user }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" value="{{ $user->nama }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Email Akses</label>
                                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Nomor HP</label>
                                <input type="text" name="no_hp" class="form-control" value="{{ $user->no_hp }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Password Baru <span class="text-muted fw-normal">(Opsional)</span></label>
                                <input type="text" name="password" class="form-control" placeholder="Kosongkan jika tidak diganti">
                            </div>
                        </div>

                        @if($user_login->role === 'admin_pusat')
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-primary">Tugaskan Sebagai Admin di Cabang:</label>
                                <select name="id_cabang" class="form-select bg-light" required>
                                    <option value="">-- Pilih Cabang --</option>
                                    @foreach($data_cabang as $c)
                                        <option value="{{ $c->id_cabang }}" {{ $user->id_cabang == $c->id_cabang ? 'selected' : '' }}>
                                            {{ $c->nama_cabang }} ({{ $c->kota }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <div class="alert alert-info py-2 small">
                                <i class="bi bi-info-circle me-1"></i> Anda sedang mengedit akun Kurir di cabang Anda.
                            </div>
                        @endif

                        <div class="mb-4">
                            <label class="form-label fw-bold small">Alamat Domisili</label>
                            <textarea name="alamat" class="form-control" rows="2" required>{{ $user->alamat }}</textarea>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="/users" class="btn btn-outline-secondary px-4 fw-bold">Batal</a>
                            <button type="submit" class="btn btn-warning px-4 fw-bold">Update Akun</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection