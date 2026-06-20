<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Tarif Ongkir - ngirim.id</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', sans-serif; }
        .hero-section {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            color: white;
            padding: 60px 0 100px;
            text-align: center;
            border-bottom-left-radius: 50px;
            border-bottom-right-radius: 50px;
        }
        .calculator-box {
            max-width: 800px;
            margin: -60px auto 0;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

    <div class="hero-section">
        <div class="container">
            <h1 class="fw-bold"><i class="bi bi-tags me-2"></i>Cek Ongkir</h1>
            <p class="lead opacity-75">Hitung estimasi biaya pengiriman paket Anda ke seluruh Indonesia</p>
        </div>
    </div>

    <div class="container">
        <div class="calculator-box">
            <form action="/cek-ongkir" method="POST">
                @csrf
                
                @php 
                    $semua_cabang = \App\Models\Cabang::all(); 
                @endphp

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-muted small">KOTA ASAL</label>
                        <select name="asal" class="form-select form-select-lg bg-light" required>
                            <option value="">-- Pilih Asal --</option>
                            @foreach($semua_cabang as $cabang)
                                <option value="{{ $cabang->kota }}" {{ (isset($input_asal) && $input_asal == $cabang->kota) ? 'selected' : '' }}>
                                    {{ $cabang->kota }} ({{ $cabang->nama_cabang }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-muted small">KOTA TUJUAN</label>
                        <select name="tujuan" class="form-select form-select-lg bg-light" required>
                            <option value="">-- Pilih Tujuan --</option>
                            @foreach($semua_cabang as $cabang)
                                <option value="{{ $cabang->kota }}" {{ (isset($input_tujuan) && $input_tujuan == $cabang->kota) ? 'selected' : '' }}>
                                    {{ $cabang->kota }} ({{ $cabang->nama_cabang }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-2">
                        <label class="form-label fw-bold text-muted small">BERAT (KG)</label>
                        <input type="number" name="berat" class="form-control form-control-lg bg-light" value="{{ $input_berat ?? '1' }}" min="1" required>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold">HITUNG</button>
                    </div>
                </div>
            </form>
        </div>

        @if(isset($hasil))
            <div class="row justify-content-center mt-5 mb-5">
                <div class="col-md-8">
                    @if($hasil)
                        <div class="card border-0 shadow-sm rounded-4 border-top border-primary border-4">
                            <div class="card-body p-4 text-center">
                                <h5 class="text-muted mb-4">Hasil Pencarian Tarif</h5>
                                <div class="row align-items-center mb-4">
                                    <div class="col-5 text-end">
                                        <h4 class="fw-bold text-dark mb-0">{{ $input_asal }}</h4>
                                    </div>
                                    <div class="col-2 text-center text-primary fs-3">
                                        <i class="bi bi-arrow-right-circle-fill"></i>
                                    </div>
                                    <div class="col-5 text-start">
                                        <h4 class="fw-bold text-dark mb-0">{{ $input_tujuan }}</h4>
                                    </div>
                                </div>
                                
                                <div class="bg-light rounded-3 p-3 mb-3 d-flex justify-content-between align-items-center">
                                    <div class="text-start">
                                        <span class="d-block text-muted small fw-bold">Layanan</span>
                                        <span class="fw-bold text-dark fs-5">Reguler ({{ $hasil->estimasi_hari }} Hari)</span>
                                    </div>
                                    <div class="text-end">
                                        <span class="d-block text-muted small fw-bold">Total Biaya ({{ $input_berat }} Kg)</span>
                                        <span class="fw-bold text-primary fs-3">Rp {{ number_format($hasil->harga_per_kg * $input_berat, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning text-center shadow-sm py-4 rounded-4">
                            <i class="bi bi-emoji-frown fs-1 d-block mb-2"></i>
                            <h5 class="fw-bold">Rute Tidak Ditemukan</h5>
                            <p class="mb-0">Maaf, layanan ngirim.id belum tersedia untuk rute pengiriman dari <b>{{ $input_asal }}</b> ke <b>{{ $input_tujuan }}</b>.</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>

</body>
</html>