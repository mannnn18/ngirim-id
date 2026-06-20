@extends('layouts.app')
@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0 fw-bold"><i class="bi bi-box-seam me-2"></i> Input Transaksi Paket Baru</h5>
        </div>
        <div class="card-body p-4">
            <form action="/paket" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 border-end">
                        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-person-up me-2"></i> DATA PENGIRIM</h6>
                        
                        <div class="mb-3">
                            <select class="form-select bg-light text-primary fw-bold border-primary" onchange="autofillPengirim(this)">
                                <option value="">+ Input Manual (Ketik di bawah) ATAU Pilih Pelanggan Terdaftar</option>
                                @foreach($pelanggan_terdaftar as $user)
                                    <option value="{{ $user->nama }}|{{ $user->no_hp }}|{{ $user->alamat }}">
                                        {{ $user->nama }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nama Pengirim</label>
                            <input type="text" id="nama_pengirim" name="nama_pengirim" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">No. Telepon</label>
                            <input type="number" id="telp_pengirim" name="telp_pengirim" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Alamat Lengkap</label>
                            <textarea id="alamat_pengirim" name="alamat_pengirim" class="form-control" rows="2" required></textarea>
                        </div>
                    </div>

                    <div class="col-md-6 ps-md-4">
                        <h6 class="fw-bold text-success mb-3"><i class="bi bi-person-down me-2"></i> DATA PENERIMA</h6>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nama Penerima</label>
                            <input type="text" name="nama_penerima" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">No. Telepon</label>
                            <input type="number" name="telp_penerima" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Alamat Lengkap Tujuan</label>
                            <textarea name="alamat_penerima" class="form-control" rows="2" required></textarea>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <h6 class="fw-bold text-dark mb-3"><i class="bi bi-truck me-2"></i> INFORMASI PAKET & RUTE CABANG</h6>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label small fw-bold">Isi Paket</label>
                        <input type="text" name="isi_paket" class="form-control" placeholder="Cth: Sepatu" required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label small fw-bold">Kategori</label>
                        <select name="kategori" class="form-select" required>
                            <option value="Dokumen">Dokumen</option>
                            <option value="Elektronik">Elektronik</option>
                            <option value="Pakaian">Pakaian</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label small fw-bold">Berat (Kg)</label>
                        <input type="number" id="inputBerat" name="berat" class="form-control" value="1" min="1" required oninput="hitungHarga()">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label small fw-bold text-success">Total Harga</label>
                        <input type="text" id="tampilHarga" class="form-control fw-bold text-success bg-light" value="Rp 15.000" readonly>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label small fw-bold text-success">Pembayaran</label>
                        <select name="metode_pembayaran" class="form-select border-success" required>
                            <option value="Cash">Tunai (Cash)</option>
                            <option value="Transfer">Transfer Bank/Qris</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label class="form-label small fw-bold text-danger">Kirim Ke Cabang Tujuan:</label>
                        <select name="id_cabang_tujuan" id="selectTujuan" class="form-select border-danger" required onchange="hitungHarga()">
                            <option value="" data-harga="0">-- Pilih Tujuan --</option>
                            @foreach($data_cabang as $cabang)
                                @if($cabang->id_cabang !== auth()->user()->id_cabang)
                                    @php
                                        // Cari tarif rute ini di database (Asal -> Tujuan)
                                        $kota_asal = auth()->user()->cabang->kota ?? '';
                                        $tarif = \App\Models\Tarif::where('kota_asal', $kota_asal)
                                                                  ->where('kota_tujuan', $cabang->kota)
                                                                  ->first();
                                        // Jika tarif ditemukan, pakai harganya. Jika tidak, default 15000
                                        $harga_rute = $tarif ? $tarif->harga_per_kg : 15000;
                                    @endphp
                                    <option value="{{ $cabang->id_cabang }}" data-harga="{{ $harga_rute }}">
                                        {{ $cabang->nama_cabang }} ({{ $cabang->kota }}) - Rp {{ number_format($harga_rute, 0, ',', '.') }}/kg
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 d-flex align-items-end mb-3">
                        <button type="submit" class="btn btn-primary w-100 fw-bold shadow-sm">SIMPAN PAKET</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Fungsi Auto-fill pengirim (yang sebelumnya sudah ada)
    function autofillPengirim(select) {
        if(select.value) {
            let data = select.value.split('|');
            document.getElementById('nama_pengirim').value = data[0];
            document.getElementById('telp_pengirim').value = data[1];
            document.getElementById('alamat_pengirim').value = data[2];
        } else {
            document.getElementById('nama_pengirim').value = '';
            document.getElementById('telp_pengirim').value = '';
            document.getElementById('alamat_pengirim').value = '';
        }
    }

    // FUNGSI BARU: Hitung Harga Real-time
    function hitungHarga() {
        let berat = document.getElementById('inputBerat').value;
        let dropdownTujuan = document.getElementById('selectTujuan');
        
        let tarifPerKg = 0;
        
        // Ambil harga dari atribut 'data-harga' pada cabang yang dipilih
        if(dropdownTujuan.value !== "") {
            tarifPerKg = dropdownTujuan.options[dropdownTujuan.selectedIndex].getAttribute('data-harga');
        }
        
        let total = (berat && berat > 0) ? berat * tarifPerKg : 0;
        
        let formatRupiah = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(total);
        
        document.getElementById('tampilHarga').value = formatRupiah;
    }

    // Jalankan hitungan otomatis 1 kali saat halaman pertama kali dibuka
    document.addEventListener("DOMContentLoaded", function() {
        hitungHarga();
    });
</script>
@endsection