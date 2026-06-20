<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ngirim.id</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f0f4f8; }
        .login-card { border-radius: 1rem; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .login-header { background-color: #0d6efd; color: white; border-radius: 1rem 1rem 0 0; padding: 2rem; text-align: center; }
    </style>
</head>
<body class="d-flex align-items-center min-vh-100">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card login-card">
                    <div class="login-header">
                        <i class="bi bi-box-fill fs-1"></i>
                        <h3 class="fw-bold tracking-wider mt-2">ngirim.id</h3>
                        <p class="mb-0 opacity-75">Sistem Manajemen Ekspedisi</p>
                    </div>
                    
                    <div class="card-body p-4 p-md-5">
                        <h5 class="fw-bold text-center mb-4 text-dark">Silakan Masuk</h5>

                        @if(session('error'))
                            <div class="alert alert-danger py-2 text-center shadow-sm">
                                <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ session('error') }}
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success py-2 text-center shadow-sm">
                                <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
                            </div>
                        @endif

                        <form action="/login" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted small">Email Address</label>
                                <input type="email" name="email" class="form-control form-control-lg bg-light" placeholder="admin@ngirim.id" required autofocus>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold text-muted small">Password</label>
                                <input type="password" name="password" class="form-control form-control-lg bg-light" placeholder="••••••••" required>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg fw-bold">Masuk ke Sistem</button>
                                
                                <a href="/" class="btn btn-outline-secondary btn-lg fw-bold">
                                    <i class="bi bi-arrow-left me-2"></i>Kembali ke Beranda
                                </a>
                            </div>

                            <div class="text-center mt-4">
                                Belum punya akun? <a href="/register" class="fw-bold text-decoration-none">Daftar Sekarang</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>