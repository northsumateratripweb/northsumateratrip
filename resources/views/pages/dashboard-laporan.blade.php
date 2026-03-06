@extends('layouts.main')
@section('title', 'Dashboard Laporan Pesanan')
@section('content')
<div class="container py-5">
    <h1 class="mb-4">Dashboard Laporan Pesanan</h1>
    <form method="get" action="{{ route('dashboard.laporan') }}" class="mb-4">
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
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5>Total Pesanan Bulan Ini</h5>
                    <h2>{{ $totalBulan }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5>Total Pesanan Tahun Ini</h5>
                    <h2>{{ $totalTahun }}</h2>
                </div>
            </div>
        </div>
    </div>
    <a href="{{ route('laporan.pesanan', ['tahun' => $tahun, 'bulan' => $bulan]) }}" class="btn btn-success">Lihat Tabel Laporan</a>
</div>
@endsection
