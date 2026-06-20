<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Resi - {{ $paket->resi }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f0f0f0;
        }
        .label-box {
            width: 100%;
            max-width: 400px; /* Ukuran standar kertas thermal/A6 */
            background-color: #fff;
            border: 2px solid #000;
            margin: 0 auto;
            padding: 15px;
            box-sizing: border-box;
        }
        .header {
            text-align: center;
            border-bottom: 2px dashed #000;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        .header h2 { margin: 0; font-size: 24px; letter-spacing: 2px; }
        .header p { margin: 5px 0 0; font-size: 14px; }
        
        .resi-number {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin: 10px 0;
            padding: 10px;
            background-color: #000;
            color: #fff;
            letter-spacing: 1px;
        }

        .section {
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        .section-title {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .content-text {
            font-size: 14px;
            font-weight: bold;
            margin: 0;
        }
        .content-sub {
            font-size: 12px;
            margin: 2px 0 0 0;
        }

        .grid-2 {
            display: flex;
            justify-content: space-between;
        }
        
        .footer {
            text-align: center;
            font-size: 10px;
            margin-top: 15px;
        }

        /* Tombol ini akan disembunyikan saat masuk ke mode print (kertas) */
        .btn-print {
            display: block;
            width: 100%;
            max-width: 400px;
            margin: 20px auto;
            padding: 15px;
            background-color: #0d6efd;
            color: white;
            text-align: center;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            border: none;
        }

        @media print {
            body { background-color: #fff; padding: 0; }
            .label-box { border: none; max-width: 100%; }
            .btn-print { display: none; } /* Sembunyikan tombol saat nge-print */
        }
    </style>
</head>
<body>

    <button onclick="window.print()" class="btn-print">🖨️ KLIK UNTUK CETAK RESI</button>

    <div class="label-box">
        <div class="header">
            <h2>ngirim.id</h2>
            <p>Layanan Ekspedisi Kilat Nusantara</p>
        </div>

        <div class="resi-number">
            {{ $paket->resi }}
        </div>

        <div class="section grid-2">
            <div>
                <div class="section-title">Penerima</div>
                <p class="content-text">{{ $paket->penerima->nama }}</p>
                <p class="content-sub">{{ $paket->penerima->no_hp }}</p>
            </div>
            <div style="text-align: right;">
                <div class="section-title">Pengirim</div>
                <p class="content-text">{{ $paket->pengirim->nama }}</p>
                <p class="content-sub">{{ $paket->pengirim->no_hp }}</p>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Detail Paket</div>
            <p class="content-text">{{ $paket->isi_paket }}</p>
            <div class="grid-2" style="margin-top: 10px;">
                <div>Berat: <b>{{ $paket->berat }} Kg</b></div>
                <div>Asal: <b>{{ $paket->cabang->kota ?? 'Pusat' }}</b></div>
            </div>
        </div>

        <div class="footer">
            Dicetak pada: {{ \Carbon\Carbon::now()->format('d M Y H:i') }}<br>
            <i>Harap tempelkan resi ini pada bagian permukaan paket yang rata.</i>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>