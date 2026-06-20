@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h3 class="fw-bold mb-4"><i class="bi bi-box-arrow-in-down text-success me-2"></i> Penerimaan Paket Masuk</h3>

    <form action="/transit/terima" method="POST">
        @csrf
        <div class="card border-0 shadow-sm rounded-4">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="bg-success text-white">
                        <tr>
                            <th class="ps-4"><input type="checkbox" id="checkAll" class="form-check-input"></th>
                            <th>No. Resi</th>
                            <th>Asal Pengiriman</th>
                            <th>Status Saat Ini</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($paket_masuk as $p)
                        <tr>
                            <td class="ps-4"><input type="checkbox" name="id_paket[]" value="{{ $p->id_paket }}" class="form-check-input check-item"></td>
                            <td class="fw-bold">{{ $p->resi }}</td>
                            <td>Dari: {{ $p->pengiriman->last()->asal ?? 'Cabang Asal' }}</td>
                            <td><span class="badge bg-warning text-dark">{{ $p->status }}</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-4">Tidak ada paket menuju cabang ini saat ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white p-3 text-end">
                <button type="submit" class="btn btn-success fw-bold px-5">KONFIRMASI BARANG DITERIMA</button>
            </div>
        </div>
    </form>
</div>

<script>
    document.getElementById('checkAll').onclick = function() {
        var checkboxes = document.querySelectorAll('.check-item');
        for (var checkbox of checkboxes) checkbox.checked = this.checked;
    }
</script>
@endsection