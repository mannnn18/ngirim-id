<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ngirim.id - Kirim Paket Hemat Terus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; overflow-x: hidden; background-color: #f8f9fa; }
        .navbar { background-color: #ffffff; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        
        /* Bagian Hero (Atas) */
        .hero {
            background: url('https://images.unsplash.com/photo-1580674684081-77673ce72cdd?q=80&w=1920&auto=format&fit=crop') center/cover no-repeat;
            position: relative;
            color: white;
            padding: 80px 0 60px;
        }
        .hero::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(90deg, rgba(13,110,253,0.95) 0%, rgba(13,110,253,0.8) 50%, rgba(0,0,0,0.4) 100%);
        }
        .hero-content { position: relative; z-index: 10; }
        .hero-title { font-size: 4.5rem; font-weight: 900; line-height: 1.1; margin-bottom: 20px; text-transform: uppercase; letter-spacing: -2px; text-shadow: 2px 2px 4px rgba(0,0,0,0.3); }
        
        /* Kotak Promo */
        .promo-box {
            background-color: #dc3545; /* Merah untuk menarik perhatian */
            border-radius: 15px;
            padding: 10px 20px;
            display: inline-block;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
            transform: rotate(-2deg);
            margin-right: 15px;
            margin-bottom: 15px;
            border: 2px solid white;
        }
        .promo-box h4 { margin: 0; font-size: 1rem; font-weight: bold; text-transform: uppercase; border-bottom: 1px solid rgba(255,255,255,0.3); padding-bottom: 5px; margin-bottom: 5px;}
        .promo-box h2 { margin: 0; font-size: 2rem; font-weight: 900; }

        /* Fitur 5 Ikon (Pita Biru) */
        .feature-strip { background-color: #0d6efd; color: white; padding: 40px 0; }
        .feature-item { text-align: center; padding: 0 15px; }
        .feature-icon { font-size: 3.5rem; margin-bottom: 15px; display: block; }
        .feature-text { font-size: 0.95rem; font-weight: 600; line-height: 1.3; }

        /* Widget Pencarian (Floating) */
        .search-widget {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-top: -30px;
            position: relative;
            z-index: 20;
        }

        /* Bagian Berita / News */
        .news-section { padding: 60px 0; }
        .nav-tabs .nav-link { color: #6c757d; font-weight: bold; border: none; border-bottom: 3px solid transparent; font-size: 1.1rem; padding: 10px 20px; }
        .nav-tabs .nav-link.active { color: #0d6efd; border-bottom: 3px solid #0d6efd; background: transparent; }
        .news-item { background: white; border-radius: 10px; overflow: hidden; margin-bottom: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); transition: 0.3s; display: flex;}
        .news-item:hover { box-shadow: 0 10px 20px rgba(0,0,0,0.1); transform: translateY(-3px); }
        .news-img { width: 150px; min-height: 100px; background-color: #e9ecef; object-fit: cover; }
        .news-content { padding: 15px; flex-grow: 1; display: flex; flex-direction: column; justify-content: center;}
        .news-date { font-size: 0.8rem; color: #adb5bd; margin-top: 10px; }
        
        .footer { background-color: #212529; color: #adb5bd; padding: 40px 0 20px; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light sticky-top py-3">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary fs-3" href="/">
                <i class="bi bi-box-seam-fill me-2"></i>ngirim.id
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto fw-semibold">
                    <li class="nav-item"><a class="nav-link text-dark" href="/lacak">Search</a></li>
                    <li class="nav-item"><a class="nav-link text-dark" href="/cek-ongkir">Cek Ongkir</a></li>
                </ul>
                <div class="d-flex align-items-center">
                @guest
                    <a href="/login" class="btn btn-primary px-4 fw-bold rounded-pill">
                        <i class="bi bi-person me-2"></i>Login/Register
                    </a>
                @else
                    <div class="dropdown">
                        <a class="btn btn-outline-primary dropdown-toggle px-4 fw-bold rounded-pill" href="#" role="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-2"></i>{{ auth()->user()->nama }}
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="userMenu">
                            <li><a class="dropdown-item py-2" href="/paket-saya"><i class="bi bi-box-seam me-2"></i>Paket Saya</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="/logout" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 text-danger fw-bold">
                                        <i class="bi bi-box-arrow-right me-2"></i>Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endguest
            </div>
        </div>
    </nav>

    <section class="hero">
        <div class="container hero-content">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <h1 class="hero-title">KIRIM PAKET<br>HEMAT TERUSSSS</h1>
                    <p class="fs-5 mb-4 opacity-75">Di ngirim.id Express</p>
                    
                    <div class="d-flex flex-wrap">
                        <div class="promo-box">
                            <h4>Senin-Jumat</h4>
                            <h2>DISKON ONGKIR 25%</h2>
                        </div>
                        <div class="promo-box" style="background-color: #212529; transform: rotate(2deg);">
                            <h4>Sabtu-Minggu</h4>
                            <h2 class="text-warning">DISKON ONGKIR 40%</h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 d-none d-lg-flex justify-content-center">
                    
                    <img src="{{ asset('images/kurir.png') }}" 
                        alt="Foto Kurir Ngirim.id" 
                        class="img-fluid rounded-4 shadow-lg border border-4 border-dark" 
                        style="max-height: 500px; transform: rotate(5deg);">

                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="search-widget d-flex gap-2">
                    <form action="/lacak" method="GET" class="d-flex w-100 gap-2">
                        <input type="text" name="resi" class="form-control form-control-lg bg-light border-0" placeholder="Lacak Resi (Contoh: NGR-...)" required style="text-transform: uppercase;">
                        <button type="submit" class="btn btn-dark btn-lg px-4 fw-bold"><i class="bi bi-search"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <section class="feature-strip mt-5">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-6 col-md-2 feature-item">
                    <i class="bi bi-airplane feature-icon"></i>
                    <div class="feature-text">Menjangkau Se-Indonesia<br><small class="fw-normal opacity-75">Tanpa Pihak ke-3</small></div>
                </div>
                <div class="col-6 col-md-2 feature-item">
                    <i class="bi bi-geo-alt feature-icon"></i>
                    <div class="feature-text">Real Time<br>Tracking System</div>
                </div>
                <div class="col-6 col-md-2 feature-item">
                    <i class="bi bi-calendar2-check feature-icon"></i>
                    <div class="feature-text">Operasional<br>365 hari</div>
                </div>
                <div class="col-6 col-md-2 feature-item">
                    <i class="bi bi-truck feature-icon"></i>
                    <div class="feature-text">Harga Regular<br>Service Premium</div>
                </div>
                <div class="col-6 col-md-2 feature-item">
                    <i class="bi bi-headset feature-icon"></i>
                    <div class="feature-text">24 Jam Layanan<br>Keluhan Pelanggan</div>
                </div>
            </div>
        </div>
    </section>

    <section class="news-section">
        <div class="container">
            <ul class="nav nav-tabs justify-content-center mb-5" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#news">News</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#events">Events</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#employee">Top Employee</button>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="news">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <a href="#" class="text-decoration-none text-dark">
                                <div class="news-item">
                                    <img src="{{ asset('images/foto-kurir.jpeg') }}" alt="News 1" class="news-img">
                                    <div class="news-content">
                                        <h5 class="fw-bold mb-1">Pemberitahuan Keterlambatan Pengiriman</h5>
                                        <div class="news-date"><i class="bi bi-clock me-1"></i> {{ date('Y-m-d') }}</div>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="text-decoration-none text-dark">
                                <div class="news-item">
                                    <img src="{{ asset('images/foto-kurir.jpeg') }}" alt="News 2" class="news-img">
                                    <div class="news-content">
                                        <h5 class="fw-bold mb-1">Kenaikan Harga</h5>
                                        <div class="news-date"><i class="bi bi-clock me-1"></i> 2026-04-01</div>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="text-decoration-none text-dark">
                                <div class="news-item">
                                    <img src="{{ asset('images/foto-kurir.jpeg') }}" alt="News 3" class="news-img">
                                    <div class="news-content">
                                        <h5 class="fw-bold mb-1">Kebijakan Pengiriman Terbaru</h5>
                                        <div class="news-date"><i class="bi bi-clock me-1"></i> 2026-03-13</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade text-center py-5" id="events"><p class="text-muted">Tidak ada event saat ini.</p></div>
                <div class="tab-pane fade text-center py-5" id="employee"><p class="text-muted">Daftar Top Employee bulan ini sedang diperbarui.</p></div>
            </div>
        </div>
    </section>

    <footer class="footer text-center">
        <div class="container">
            <h4 class="text-white fw-bold"><i class="bi bi-box-seam-fill me-2"></i>ngirim.id</h4>
            <p class="small mt-2 mb-0">© 2026 PT Ekspedisi Ngirim Indonesia. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>