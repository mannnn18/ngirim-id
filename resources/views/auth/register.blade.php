<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - ngirim.id</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f4f7f6; display: flex; align-items: center; min-height: 100vh; }
        .register-card { border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); overflow: hidden; }
        
        .bg-login-image { 
            /* Masukkan fungsi asset() di dalam tanda kutip url() */
            background: url('{{ asset('images/foto-kurir.jpeg') }}') center/cover;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card register-card">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center mb-4">
                                    <h4 class="text-dark fw-bold mb-1">Buat Akun Baru</h4>
                                    <p class="text-muted small">Daftar untuk mulai mengirim paket dengan mudah.</p>
                                </div>
                                
                                @if ($errors->any())
                                    <div class="alert alert-danger small p-2">
                                        <ul class="mb-0 ps-3">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form action="/register" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold text-muted">NAMA LENGKAP</label>
                                        <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required placeholder="Contoh: Budi Santoso">
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold text-muted">EMAIL</label>
                                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="budi@email.com">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold text-muted">NO. WHATSAPP</label>
                                            <input type="number" name="no_hp" class="form-control" value="{{ old('no_hp') }}" required placeholder="08123456789">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold text-muted">ALAMAT LENGKAP</label>
                                        <textarea name="alamat" class="form-control" rows="2" required placeholder="Masukkan alamat lengkap pengiriman">{{ old('alamat') }}</textarea>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold text-muted">PASSWORD</label>
                                            <input type="password" name="password" class="form-control" required placeholder="Minimal 6 karakter">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold text-muted">ULANGI PASSWORD</label>
                                            <input type="password" name="password_confirmation" class="form-control" required placeholder="Ketik ulang password">
                                        </div>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary w-100 fw-bold mb-3">Daftar Akun</button>
                                    
                                    <div class="text-center small">
                                        Sudah punya akun? <a href="/login" class="fw-bold text-decoration-none">Masuk di sini!</a>
                                    </div>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>