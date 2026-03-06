@extends('layouts.main')
@section('title', 'Laporan Pesanan')
@section('content')
<div class="container py-5">
    <h1 class="mb-4">Laporan Pesanan</h1>
    <form method="get" action="{{ route('laporan.pesanan') }}" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <label>Tahun</label>
                <input type="number" name="tahun" value="{{ $tahun }}" class="form-control">
            </div>
            <div class="col-md-3">
                <label>Bulan</label>
                <input type="number" name="bulan" value="{{ $bulan }}" class="form-control" min="1" max="12">
            </div>
            <div class="col-md-3 align-self-end">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>
    <div class="mb-3">
        <a href="{{ route('laporan.pesanan.csv', ['tahun' => $tahun, 'bulan' => $bulan]) }}" class="btn btn-outline-secondary">Unduh CSV</a>
        <a href="{{ route('laporan.pesanan.excel', ['tahun' => $tahun, 'bulan' => $bulan]) }}" class="btn btn-outline-success">Unduh Excel</a>
    </div>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tipe</th>
                <th>Item</th>
                <th>Tgl Mulai</th>
                <th>Tgl Selesai</th>
                <th>Pelanggan</th>
                <th>Total Harga</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->type }}</td>
                <td>{{ $order->vehicle->name ?? $order->rentalPackage->name ?? $order->product->name ?? '-' }}</td>
                <td>{{ $order->trip_date }}</td>
                <td>{{ $order->trip_end_date }}</td>
                <td>{{ $order->customer_name }}</td>
                <td>Rp{{ number_format($order->total_price,0,',','.') }}</td>
                <td>{{ $order->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
