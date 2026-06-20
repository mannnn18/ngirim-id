@extends('layouts.app')
@section('content')
<div class="container">
    <h3 class="fw-bold mb-4">Paket Siap Antar</h3>
    
    <form action="/kurir/klaim" method="POST">
        @csrf
        <div class="card border-0 shadow-sm rounded-4">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Pilih</th>
                            <th>No. Resi</th>
                            <th>Penerima & Alamat</th>
                            <th>Isi Paket</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($paket_tersedia as $p)
                        <tr>
                            <td><input type="checkbox" name="id_paket[]" value="{{ $p->id_paket }}" class="form-check-input"></td>
                            <td class="fw-bold">{{ $p->resi }}</td>
                            <td>
                                <b>{{ $p->penerima->nama }}</b><br>
                                <small class="text-muted">{{ $p->penerima->alamat }}</small>
                            </td>
                            <td>{{ $p->isi_paket }} ({{ $p->kategori }})</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white p-3">
                <button type="submit" class="btn btn-primary fw-bold w-100">AMBIL PAKET UNTUK DIANTAR</button>
            </div>
        </div>
    </form>
</div>
@endsection