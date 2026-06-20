@extends('layouts.app')

@section('title', 'ngirim.id - Dashboard Utama')

@section('content')
    <section class="py-5 text-white" style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=1350&q=80'); background-size: cover;">
        <div class="container py-5 text-center">
            <h1 class="display-3 fw-bold">KIRIM PAKET<br>HEMAT TERUSSS</h1>
            <p class="lead">Dapatkan diskon ongkir hingga 40% setiap akhir pekan!</p>
            <div class="mt-4">
                <button class="btn btn-warning btn-lg fw-bold px-5 py-3 shadow">CEK TARIF SEKARANG</button>
            </div>
        </div>
    </section>

    <div class="container my-5 text-center">
        <div class="row g-4">
            <div class="col-md-3">
                <i class="bi bi-geo-alt-fill text-primary fs-1"></i>
                <h5 class="mt-2">Real Time Tracking</h5>
            </div>
            <div class="col-md-3">
                <i class="bi bi-clock-history text-primary fs-1"></i>
                <h5 class="mt-2">Operasional 365 Hari</h5>
            </div>
            <div class="col-md-3">
                <i class="bi bi-truck text-primary fs-1"></i>
                <h5 class="mt-2">Harga Reguler Premium</h5>
            </div>
            <div class="col-md-3">
                <i class="bi bi-headset text-primary fs-1"></i>
                <h5 class="mt-2">Layanan 24 Jam</h5>
            </div>
        </div>
    </div>
@endsection