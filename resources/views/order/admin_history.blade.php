@extends('layouts.main')

@section('title', 'Laporan Order')
{{-- laporan order --}}
@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4 d-print-none">
        <h2 class="fw-bold text-primary"><i class="bi bi-clipboard-data"></i> Laporan Riwayat Order</h2>
        <button onclick="window.print()" class="btn btn-dark rounded-pill px-4">
            <i class="bi bi-printer me-2"></i> Cetak Laporan
        </button>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3">ID</th>
                        <th>PEMBELI</th>
                        <th>PRODUK</th>
                        <th>TANGGAL</th>
                        <th>TOTAL</th>
                        <th class="pe-4">STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td class="ps-4 fw-bold">#{{ $order->orderID }}</td>
                        <td>
                            <strong>{{ $order->user?->nama ?? 'User Terhapus' }}</strong>
                        </td>
                        <td>
                            <ul class="list-unstyled mb-0 small text-secondary">
                                @foreach($order->detail as $item)
                                    @if($item->produk)
                                        <li>• {{ $item->qty }}x {{ $item->produk->namaproduk }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ $order->tanggal_order }}</td>
                        <td class="fw-bold text-primary">Rp {{ number_format($order->totalharga, 0, ',', '.') }}</td>
                        <td class="pe-4">
                            <span class="badge rounded-pill {{ $order->status == 'paid' ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ $order->status == 'paid' ? 'Lunas' : 'Pending' }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    @media print {
        .navbar, .sidebar, footer, .btn, .d-print-none { display: none !important; }
        .container { width: 100% !important; max-width: none !important; margin: 0; }
        .card { border: none !important; box-shadow: none !important; }
    }
</style>
@endsection