@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h3 class="fw-bold mb-4"><i class="bi bi-truck-flatbed text-primary me-2"></i> Kirim Paket Antar Cabang</h3>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <label class="fw-bold small text-muted">Filter Berdasarkan Cabang Tujuan:</label>
            <select id="filterCabang" class="form-select bg-light w-auto" onchange="filterTabel()">
                <option value="ALL">Tampilkan Semua Tujuan</option>
                @foreach($cabang_tujuan as $c)
                    <option value="{{ $c->nama_cabang }}">{{ $c->nama_cabang }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <form action="/transit/kirim" method="POST">
        @csrf
        <div class="card border-0 shadow-sm rounded-4">
            <div class="table-responsive">
                <table class="table align-middle" id="tabelKirim">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="ps-4"><input type="checkbox" id="checkAll" class="form-check-input"></th>
                            <th>No. Resi</th>
                            <th>Tujuan Cabang</th>
                            <th>Penerima</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($paket_siap_kirim as $p)
                        <tr class="row-paket" data-tujuan="{{ $p->cabangTujuan->nama_cabang ?? 'Pusat' }}">
                            <td class="ps-4"><input type="checkbox" name="id_paket[]" value="{{ $p->id_paket }}" class="form-check-input check-item"></td>
                            <td class="fw-bold">{{ $p->resi }}</td>
                            <td><span class="badge bg-danger">{{ $p->cabangTujuan->nama_cabang ?? 'Pusat' }}</span></td>
                            <td>{{ $p->penerima->nama }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-4">Tidak ada paket yang menunggu dikirim.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white p-3 text-end">
                <button type="submit" class="btn btn-primary fw-bold px-5">PROSES KIRIM TERPILIH</button>
            </div>
        </div>
    </form>
</div>

<script>
    // Fitur Select All Checkbox
    document.getElementById('checkAll').onclick = function() {
        var checkboxes = document.querySelectorAll('.check-item');
        for (var checkbox of checkboxes) {
            // Hanya centang baris yang tidak disembunyikan oleh filter
            if(checkbox.closest('tr').style.display !== 'none') {
                checkbox.checked = this.checked;
            }
        }
    }

    // Fitur Filter Cabang
    function filterTabel() {
        var filter = document.getElementById('filterCabang').value;
        var rows = document.querySelectorAll('.row-paket');
        
        rows.forEach(row => {
            if (filter === 'ALL' || row.getAttribute('data-tujuan') === filter) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
                row.querySelector('.check-item').checked = false; // Uncheck jika disembunyikan
            }
        });
    }
</script>
@endsection