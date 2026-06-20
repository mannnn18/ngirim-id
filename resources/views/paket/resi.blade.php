<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Resi - {{ $paket->resi }}</title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; color: #000; background: #fff; margin: 0; padding: 20px; font-size: 14px; }
        .receipt-container { max-width: 80mm; margin: 0 auto; border: 1px dashed #000; padding: 15px; }
        .text-center { text-align: center; }
        .fw-bold { font-weight: bold; }
        .mb-1 { margin-bottom: 5px; }
        .mb-3 { margin-bottom: 15px; }
        .divider { border-top: 1px dashed #000; margin: 10px 0; }
        table { width: 100%; font-size: 13px; }
        td { vertical-align: top; padding: 2px 0; }
        .barcode { font-size: 24px; letter-spacing: 2px; margin: 10px 0; display: block; font-family: 'Arial Black', sans-serif; }
        @media print {
            body { padding: 0; }
            .receipt-container { border: none; }
        }
    </style>
</head>
<body onload="window.print()">

<div class="receipt-container">
    <div class="text-center mb-3">
        <h2 style="margin:0;">ngirim.id</h2>
        <small>Solusi Logistik Terpercaya</small><br>
        <small>Cabang: {{ $paket->cabang->nama_cabang ?? 'Pusat' }}</small>
    </div>

    <div class="divider"></div>
    <div class="text-center">
        <span class="barcode">*{{ $paket->resi }}*</span>
        <div class="fw-bold">{{ $paket->resi }}</div>
        <small>{{ \Carbon\Carbon::parse($paket->created_at)->format('d M Y H:i') }}</small>
    </div>
    <div class="divider"></div>

    <table>
        <tr><td colspan="2" class="fw-bold">PENGIRIM:</td></tr>
        <tr>
            <td colspan="2">
                {{ $paket->pengirim->nama ?? '-' }}<br>
                {{ $paket->pengirim->no_hp ?? '-' }}<br>
                {{ $paket->pengirim->alamat ?? '-' }}
            </td>
        </tr>
    </table>

    <div class="divider"></div>

    <table>
        <tr><td colspan="2" class="fw-bold">PENERIMA:</td></tr>
        <tr>
            <td colspan="2">
                {{ $paket->penerima->nama ?? '-' }}<br>
                {{ $paket->penerima->no_hp ?? '-' }}<br>
                {{ $paket->penerima->alamat ?? '-' }}<br>
                <b>Tujuan: {{ $paket->cabangTujuan->nama_cabang ?? '-' }}</b>
            </td>
        </tr>
    </table>

    <div class="divider"></div>

    <table>
        <tr>
            <td>Isi Paket</td>
            <td style="text-align:right;">{{ $paket->isi_paket }}</td>
        </tr>
        <tr>
            <td>Berat</td>
            <td style="text-align:right;">{{ $paket->berat }} Kg</td>
        </tr>
        <tr>
            <td class="fw-bold mt-2">TOTAL BIAYA</td>
            <td style="text-align:right;" class="fw-bold mt-2">Rp {{ number_format($paket->harga, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Pembayaran</td>
            <td style="text-align:right;">{{ strtoupper($paket->metode_pembayaran) }} ({{ strtoupper($paket->status_pembayaran) }})</td>
        </tr>
    </table>

    <div class="divider"></div>
    
    <div class="text-center mt-4">
        <small>Terima kasih telah menggunakan layanan kami.</small><br>
        <small>Lacak resi Anda di <b>www.ngirim.id</b></small>
    </div>
</div>

</body>
</html>