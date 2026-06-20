<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - ngirim.id')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { background-color: #f8f9fa; overflow-x: hidden; }
        .sidebar { width: 260px; min-height: 100vh; background-color: #0d6efd; position: fixed; top: 0; left: 0; z-index: 100; transition: all 0.3s ease-in-out; }
        .sidebar .nav-link { color: rgba(255, 255, 255, 0.8); border-radius: 8px; margin-bottom: 5px; padding: 10px 15px; }
        .sidebar .nav-link:hover { background-color: rgba(255, 255, 255, 0.15); color: #fff; }
        .sidebar .nav-link.active { background-color: #fff; color: #0d6efd; font-weight: bold; }
        .main-content { margin-left: 260px; min-height: 100vh; width: calc(100% - 260px); }
        .topbar { height: 60px; background-color: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.05); display: flex; align-items: center; padding: 0 20px; }
    </style>
</head>
<body class="d-flex">

    <div class="sidebar p-3 shadow-lg d-flex flex-column" id="sidebar">
        <a href="/dashboard" class="d-flex align-items-center mb-4 text-white text-decoration-none px-2">
            <i class="bi bi-box-fill fs-3 me-2"></i>
            <span class="fs-4 fw-bold">ngirim.id</span>
        </a>
        
        <ul class="nav flex-column mb-auto">
            <li class="nav-item">
                <a href="/dashboard" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>
            
            @php $role = auth()->user()->role; @endphp

            @if($role === 'admin_pusat' || $role === 'admin_cabang')
                <li class="nav-item mt-4 mb-2 text-white-50 small fw-bold text-uppercase px-3">Data Master</li>
                
                @if($role === 'admin_pusat')
                <li>
                    <a href="/cabang" class="nav-link {{ Request::is('cabang*') ? 'active' : '' }}">
                        <i class="bi bi-buildings me-2"></i> Manajemen Cabang
                    </a>
                </li>
                @endif

                <li>
                    <a href="/users" class="nav-link {{ Request::is('users*') ? 'active' : '' }}">
                        <i class="bi bi-people me-2"></i> 
                        {{ $role === 'admin_pusat' ? 'Manajemen Admin Cabang' : 'Manajemen Kurir' }}
                    </a>
                </li>

                @if($role === 'admin_pusat')
                <li>
                    <a href="/tarif" class="nav-link {{ Request::is('tarif*') ? 'active' : '' }}">
                        <i class="bi bi-tags me-2"></i> Tarif Ongkir
                    </a>
                </li>
                @endif
            @endif

            <li class="nav-item mt-4 mb-2 text-white-50 small fw-bold text-uppercase px-3">Operasional</li>
            
            @if($role === 'admin_pusat' || $role === 'admin_cabang')
                <li>
                    <a href="/paket" class="nav-link {{ Request::is('paket*') ? 'active' : '' }}">
                        <i class="bi bi-box-seam me-2"></i> Transaksi Paket
                    </a>
                </li>
                <li>
                    <a href="/laporan" class="nav-link {{ Request::is('laporan*') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-bar-graph me-2"></i> Laporan Bisnis
                    </a>
                </li>
            @endif

            @if($role === 'kurir')
                <li>
                    <a href="/kurir/antaran-saya" class="nav-link {{ Request::is('kurir/antaran*') ? 'active' : '' }}">
                        <i class="bi bi-truck me-2"></i> Antaran Saya
                    </a>
                </li>
                <li>
                    <a href="/kurir/antaran-aktif" class="nav-link {{ Request::is('kurir/antaran-aktif') ? 'active' : '' }}">
                        <i class="bi bi-bicycle me-2"></i> Sedang Diantar
                    </a>
                </li>
            @endif

            @if($role === 'admin_pusat' || $role === 'admin_cabang')
                <li>
                    <a href="/transit/kirim" class="nav-link {{ Request::is('transit/kirim') ? 'active' : '' }}">
                        <i class="bi bi-truck-flatbed me-2"></i> Kirim ke Cabang
                    </a>
                </li>
                <li>
                    <a href="/transit/terima" class="nav-link {{ Request::is('transit/terima') ? 'active' : '' }}">
                        <i class="bi bi-box-arrow-in-down me-2"></i> Terima Paket Masuk
                    </a>
                </li>
            @endif
            
        </ul>
        
        
        <hr class="text-white opacity-25">
        <div class="dropdown px-2">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown">
                <div class="d-flex flex-column">
                    <strong class="lh-1">{{ auth()->user()->nama }}</strong>
                    <small class="text-white-50 text-capitalize" style="font-size: 0.7rem;">{{ str_replace('_', ' ', $role) }}</small>
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark shadow border-0">
                <li>
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger fw-bold"><i class="bi bi-box-arrow-right me-2"></i> Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <div class="topbar">
            <div class="ms-auto fw-semibold text-muted small">Sistem Ekspedisi v1.0</div>
        </div>
        <div class="p-4">
            @yield('content') 
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>