<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Laporan Pesanan — NorthSumateraTrip</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --blue:    #1e40af;
            --blue-l:  #3b82f6;
            --indigo:  #4f46e5;
            --green:   #16a34a;
            --amber:   #d97706;
            --red:     #dc2626;
            --bg:      #f1f5f9;
            --card:    #ffffff;
            --border:  #e2e8f0;
            --text:    #1e293b;
            --muted:   #64748b;
        }
        body { font-family: 'Outfit', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; }

        /* ── Layout ── */
        .wrap { max-width: 1380px; margin: 0 auto; padding: 0 1.5rem; }
        header { background: linear-gradient(135deg, var(--blue) 0%, var(--indigo) 100%); color: #fff; padding: 2.5rem 0; }
        header .wrap { display: flex; flex-wrap: wrap; align-items: center; gap: 1.5rem; }
        header h1 { font-size: 1.8rem; font-weight: 800; }
        header p  { font-size: 0.875rem; opacity: .75; margin-top: .25rem; }
        .back-btn { background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.3); color: #fff; padding: .5rem 1.25rem; border-radius: 99px; font-size: .85rem; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: .4rem; transition: background .2s; }
        .back-btn:hover { background: rgba(255,255,255,.25); }
        main { padding: 2rem 0 4rem; }

        /* ── Filter bar ── */
        .filter-bar { background: var(--card); border-radius: 1rem; border: 1px solid var(--border); padding: 1.25rem 1.5rem; display: flex; flex-wrap: wrap; gap: 1rem; align-items: flex-end; margin-bottom: 1.75rem; box-shadow: 0 1px 4px rgba(0,0,0,.05); }
        .filter-bar label { display: block; font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: var(--muted); margin-bottom: .35rem; }
        .filter-bar select, .filter-bar input { border: 1.5px solid var(--border); border-radius: .6rem; padding: .5rem .85rem; font-size: .9rem; font-family: inherit; background: var(--bg); color: var(--text); outline: none; transition: border .2s; }
        .filter-bar select:focus, .filter-bar input:focus { border-color: var(--blue-l); }
        .btn { display: inline-flex; align-items: center; gap: .4rem; padding: .55rem 1.25rem; border-radius: .6rem; font-size: .875rem; font-weight: 600; font-family: inherit; cursor: pointer; border: none; text-decoration: none; transition: opacity .2s, transform .1s; }
        .btn:hover { opacity: .87; transform: translateY(-1px); }
        .btn:active { transform: translateY(0); }
        .btn-primary { background: var(--blue); color: #fff; }
        .btn-csv     { background: #475569; color: #fff; }
        .btn-excel   { background: var(--green); color: #fff; }
        .btn-csv2    { background: var(--indigo); color: #fff; }
        .btn-excel2  { background: var(--amber); color: #fff; }
        .btn-group   { display: flex; gap: .6rem; flex-wrap: wrap; margin-left: auto; }

        /* ── Stat cards ── */
        .stats-section h2 { font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: var(--muted); margin-bottom: .85rem; }
        .stat-grid   { display: grid; grid-template-columns: repeat(auto-fill, minmax(185px, 1fr)); gap: .85rem; margin-bottom: 1.25rem; }
        .stat-card   { background: var(--card); border-radius: .9rem; border: 1px solid var(--border); padding: 1.1rem 1.25rem; box-shadow: 0 1px 3px rgba(0,0,0,.04); }
        .stat-card .ico { font-size: 1.6rem; margin-bottom: .4rem; }
        .stat-card .lbl { font-size: .75rem; color: var(--muted); font-weight: 500; }
        .stat-card .val { font-size: 1.45rem; font-weight: 800; color: var(--text); margin-top: .1rem; }

        .status-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: .75rem; margin-bottom: 1.5rem; }
        .status-pill { border-radius: .75rem; border: 1px solid; padding: .75rem 1rem; display: flex; align-items: center; gap: .75rem; }
        .status-pill .cnt { font-size: 1.6rem; font-weight: 800; }
        .status-pill .lbl { font-size: .78rem; font-weight: 600; }
        .sp-yellow  { background: #fffbeb; border-color: #fde68a; color: #b45309; }
        .sp-blue    { background: #eff6ff; border-color: #bfdbfe; color: #1d4ed8; }
        .sp-green   { background: #f0fdf4; border-color: #bbf7d0; color: #15803d; }
        .sp-red     { background: #fef2f2; border-color: #fecaca; color: #b91c1c; }

        /* Yearly banner */
        .yearly-banner { background: linear-gradient(135deg, var(--blue) 0%, var(--indigo) 100%); color: #fff; border-radius: 1rem; padding: 1.5rem 2rem; margin-bottom: 1.75rem; box-shadow: 0 4px 16px rgba(30,64,175,.25); }
        .yearly-banner h2 { font-size: .8rem; opacity: .75; text-transform: uppercase; letter-spacing: .07em; margin-bottom: .85rem; }
        .yb-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 1rem; }
        .yb-item .val { font-size: 1.5rem; font-weight: 800; }
        .yb-item .lbl { font-size: .75rem; opacity: .75; }

        /* ── Chart ── */
        .chart-card  { background: var(--card); border-radius: 1rem; border: 1px solid var(--border); padding: 1.5rem; margin-bottom: 1.75rem; box-shadow: 0 1px 3px rgba(0,0,0,.04); }
        .chart-card h3 { font-size: .95rem; font-weight: 700; margin-bottom: 1.25rem; color: var(--text); }
        .bar-chart   { display: flex; align-items: flex-end; gap: 6px; height: 140px; overflow-x: auto; padding-bottom: .5rem; }
        .bar-col     { display: flex; flex-direction: column; align-items: center; gap: 3px; flex: 1; min-width: 38px; }
        .bar-cnt     { font-size: .7rem; font-weight: 700; color: var(--blue-l); min-height: 14px; }
        .bar-rect    { width: 100%; border-radius: 4px 4px 0 0; transition: height .6s ease; }
        .bar-lbl     { font-size: .65rem; color: var(--muted); text-align: center; line-height: 1.2; }

        /* ── Table ── */
        .table-card  { background: var(--card); border-radius: 1rem; border: 1px solid var(--border); overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.04); }
        .table-head  { display: flex; align-items: center; padding: 1rem 1.5rem; border-bottom: 1px solid var(--border); gap: 1rem; }
        .table-head h3 { font-size: .95rem; font-weight: 700; }
        .table-head .cnt { margin-left: auto; font-size: .8rem; color: var(--muted); }
        table        { width: 100%; border-collapse: collapse; font-size: .82rem; }
        thead th     { padding: .7rem 1rem; background: #f8fafc; font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: var(--muted); text-align: left; white-space: nowrap; }
        tbody tr     { border-top: 1px solid #f1f5f9; transition: background .15s; }
        tbody tr:hover { background: #f8fafc; }
        td           { padding: .7rem 1rem; vertical-align: middle; }
        tfoot td     { padding: .8rem 1rem; background: #f8fafc; font-weight: 700; border-top: 2px solid var(--border); }

        .badge { display: inline-flex; align-items: center; padding: 2px 9px; border-radius: 99px; font-size: .72rem; font-weight: 600; white-space: nowrap; }
        .b-tour    { background: #dcfce7; color: #166534; }
        .b-rental  { background: #ede9fe; color: #5b21b6; }
        .b-car     { background: #fef3c7; color: #92400e; }
        .b-pending { background: #fffbeb; color: #b45309; }
        .b-confirm { background: #eff6ff; color: #1d4ed8; }
        .b-done    { background: #f0fdf4; color: #15803d; }
        .b-cancel  { background: #fef2f2; color: #b91c1c; }
        .b-paid    { background: #f0fdf4; color: #16a34a; }
        .b-partial { background: #fefce8; color: #ca8a04; }
        .b-unpaid  { background: #fef2f2; color: #dc2626; }

        .no-data  { text-align: center; padding: 4rem 1rem; color: var(--muted); }
        .no-data .ico { font-size: 2.5rem; margin-bottom: .5rem; }

        /* ── Month group headers ── */
        .month-group-header { background: linear-gradient(90deg, #f1f5f9, #ffffff); padding: .5rem 1rem; font-size: .78rem; font-weight: 700; color: var(--blue); border-top: 2px solid #e0e7ff; letter-spacing: .03em; }

        @media print {
            header, .filter-bar, .btn-group { display: none !important; }
            .table-card { box-shadow: none; border: 1px solid #ccc; }
        }
        @media (max-width: 768px) {
            header h1 { font-size: 1.3rem; }
            .stat-grid { grid-template-columns: 1fr 1fr; }
        }
    </style>
</head>
<body>
<header>
    <div class="wrap">
        <div>
            <h1>📊 Laporan Pesanan</h1>
            <p>NorthSumateraTrip — Sistem Manajemen Data Pesanan</p>
        </div>
        <a href="<?php echo e(url('/admin')); ?>" class="back-btn">← Kembali ke Admin</a>
    </div>
</header>

<main>
<div class="wrap">

    
    <form method="GET" action="<?php echo e(route('laporan.pesanan')); ?>">
        <div class="filter-bar">
            <div>
                <label>Tahun</label>
                <select name="tahun">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $availableYears; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $yr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($yr); ?>" <?php echo e($tahun == $yr ? 'selected' : ''); ?>><?php echo e($yr); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </select>
            </div>
            <div>
                <label>Bulan</label>
                <select name="bulan">
                    <option value="">— Semua Bulan —</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $namaBulan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $num => $nama): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($num); ?>" <?php echo e($bulan == $num ? 'selected' : ''); ?>><?php echo e($nama); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">🔍 Filter</button>
            <div class="btn-group">
                <a href="<?php echo e(route('laporan.pesanan.csv', ['tahun'=>$tahun,'bulan'=>$bulan])); ?>"
                   class="btn btn-csv">⬇ CSV <?php echo e($bulan ? 'Bulan' : 'Tahunan'); ?></a>
                <a href="<?php echo e(route('laporan.pesanan.excel', ['tahun'=>$tahun,'bulan'=>$bulan])); ?>"
                   class="btn btn-excel">⬇ Excel <?php echo e($bulan ? 'Bulan' : 'Tahunan'); ?></a>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bulan): ?>
                <a href="<?php echo e(route('laporan.pesanan.csv', ['tahun'=>$tahun])); ?>" class="btn btn-csv2">⬇ CSV Tahunan</a>
                <a href="<?php echo e(route('laporan.pesanan.excel', ['tahun'=>$tahun])); ?>" class="btn btn-excel2">⬇ Excel Tahunan</a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </form>

    
    <?php
        $currentBulanLabel = $bulan ? ($namaBulan[$bulan] ?? $bulan) . ' ' . $tahun : 'Semua Bulan ' . $tahun;
    ?>
    <div class="stats-section">
        <h2>📅 Ringkasan — <?php echo e($currentBulanLabel); ?></h2>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($statsBulan): ?>
        <div class="stat-grid">
            <div class="stat-card"><div class="ico">📋</div><div class="lbl">Total Pesanan</div><div class="val"><?php echo e($statsBulan['total']); ?></div></div>
            <div class="stat-card"><div class="ico">💰</div><div class="lbl">Total Pendapatan</div><div class="val" style="font-size:1.1rem">Rp <?php echo e(number_format($statsBulan['revenue'],0,',','.')); ?></div></div>
            <div class="stat-card"><div class="ico">🏔️</div><div class="lbl">Paket Wisata</div><div class="val"><?php echo e($statsBulan['tour']); ?></div></div>
            <div class="stat-card"><div class="ico">🗺️</div><div class="lbl">Paket Rental</div><div class="val"><?php echo e($statsBulan['rental']); ?></div></div>
            <div class="stat-card"><div class="ico">🚗</div><div class="lbl">Rental Mobil</div><div class="val"><?php echo e($statsBulan['car']); ?></div></div>
        </div>
        <div class="status-grid">
            <div class="status-pill sp-yellow"><span class="cnt"><?php echo e($statsBulan['pending']); ?></span><span class="lbl">Pending</span></div>
            <div class="status-pill sp-blue"><span class="cnt"><?php echo e($statsBulan['confirmed']); ?></span><span class="lbl">Dikonfirmasi</span></div>
            <div class="status-pill sp-green"><span class="cnt"><?php echo e($statsBulan['completed']); ?></span><span class="lbl">Selesai</span></div>
            <div class="status-pill sp-red"><span class="cnt"><?php echo e($statsBulan['cancelled']); ?></span><span class="lbl">Dibatalkan</span></div>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    <div class="yearly-banner">
        <h2>📊 Ringkasan Tahunan <?php echo e($tahun); ?></h2>
        <div class="yb-grid">
            <div class="yb-item"><div class="val"><?php echo e($statsTahun['total']); ?></div><div class="lbl">Total Pesanan</div></div>
            <div class="yb-item"><div class="val" style="font-size:1.15rem">Rp <?php echo e(number_format($statsTahun['revenue'],0,',','.')); ?></div><div class="lbl">Total Pendapatan</div></div>
            <div class="yb-item"><div class="val"><?php echo e($statsTahun['tour']); ?></div><div class="lbl">Paket Wisata</div></div>
            <div class="yb-item"><div class="val"><?php echo e($statsTahun['rental']); ?></div><div class="lbl">Paket Rental</div></div>
            <div class="yb-item"><div class="val"><?php echo e($statsTahun['car']); ?></div><div class="lbl">Rental Mobil</div></div>
            <div class="yb-item"><div class="val"><?php echo e($statsTahun['paid']); ?></div><div class="lbl">Sudah Lunas</div></div>
            <div class="yb-item"><div class="val"><?php echo e($statsTahun['unpaid']); ?></div><div class="lbl">Belum Lunas</div></div>
        </div>
    </div>

    
    <?php
        $grafikBulanan = [];
        $namaBulanSingkat = [1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',7=>'Jul',8=>'Agt',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des'];
        for ($m = 1; $m <= 12; $m++) {
            $ct = $orders->filter(fn($o) => $o->created_at->month == $m)->count();
            $rv = $orders->filter(fn($o) => $o->created_at->month == $m && $o->status != 'cancelled')->sum('total_price');
            $grafikBulanan[] = ['bulan' => $namaBulanSingkat[$m], 'pesanan' => $ct, 'revenue' => $rv, 'num' => $m];
        }
        $maxOrders = max(array_column($grafikBulanan, 'pesanan')) ?: 1;
    ?>
    <div class="chart-card">
        <h3>📈 Grafik Pesanan Per Bulan — <?php echo e($tahun); ?></h3>
        <div class="bar-chart">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $grafikBulanan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bar-col">
                <div class="bar-cnt"><?php echo e($row['pesanan'] ?: ''); ?></div>
                <div class="bar-rect"
                     style="height: <?php echo e(max(4, ($row['pesanan'] / $maxOrders) * 120)); ?>px;
                            background: <?php echo e(($bulan && (int)$bulan === $row['num']) ? '#1e40af' : '#93c5fd'); ?>"
                     title="<?php echo e($row['bulan']); ?>: <?php echo e($row['pesanan']); ?> pesanan, Rp <?php echo e(number_format($row['revenue'],0,',','.')); ?>">
                </div>
                <div class="bar-lbl"><?php echo e($row['bulan']); ?></div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    
    <div class="table-card">
        <div class="table-head">
            <h3>📋 Daftar Pesanan — <?php echo e($currentBulanLabel); ?></h3>
            <span class="cnt"><?php echo e($orders->count()); ?> pesanan</span>
        </div>
        <div style="overflow-x:auto">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tgl Pesan</th>
                        <th>ID Transaksi</th>
                        <th>Tipe</th>
                        <th>Item / Paket</th>
                        <th>Pelanggan</th>
                        <th>No. Telp</th>
                        <th>Tgl Mulai Trip</th>
                        <th>Tgl Selesai</th>
                        <th>Pax</th>
                        <th style="text-align:right">Total (IDR)</th>
                        <th>Status</th>
                        <th>Bayar</th>
                    </tr>
                </thead>
                <tbody>
                <?php $no = 0; $prevMonth = null; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $thisMonth = $order->created_at->format('n');
                        if (!$bulan && $thisMonth !== $prevMonth) {
                            $prevMonth = $thisMonth;
                            $monthLabel = true;
                        } else {
                            $monthLabel = false;
                        }
                        $no++;

                        if ($order->vehicle_id)            { $tipeLabel = 'Rental Mobil'; $tipeBadge = 'b-car'; }
                        elseif ($order->rental_package_id) { $tipeLabel = 'Paket Rental'; $tipeBadge = 'b-rental'; }
                        else                               { $tipeLabel = 'Paket Wisata'; $tipeBadge = 'b-tour'; }

                        $statusLabel = match($order->status) {
                            'pending'   => 'Pending', 'confirmed' => 'Dikonfirmasi',
                            'completed' => 'Selesai', 'cancelled' => 'Dibatalkan',
                            default     => ucfirst($order->status)
                        };
                        $statusBadge = match($order->status) {
                            'pending' => 'b-pending', 'confirmed' => 'b-confirm',
                            'completed' => 'b-done', 'cancelled' => 'b-cancel', default => ''
                        };
                        $payLabel = match($order->payment_status) { 'paid' => 'Lunas', 'partial' => 'DP', default => 'Belum' };
                        $payBadge = match($order->payment_status) { 'paid' => 'b-paid', 'partial' => 'b-partial', default => 'b-unpaid' };
                        $item = $order->vehicle?->name ?? $order->rentalPackage?->name ?? $order->product?->name ?? '-';
                    ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($monthLabel && !$bulan): ?>
                    <tr>
                        <td colspan="13" class="month-group-header">
                            📅 <?php echo e($namaBulan[$thisMonth] ?? $thisMonth); ?> <?php echo e($tahun); ?>

                            — <?php echo e($orders->filter(fn($o) => $o->created_at->format('n') == $thisMonth)->count()); ?> pesanan
                        </td>
                    </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <tr>
                        <td style="color:#94a3b8; font-size:.75rem"><?php echo e($no); ?></td>
                        <td style="white-space:nowrap; font-size:.8rem"><?php echo e($order->created_at->format('d M Y')); ?></td>
                        <td style="font-family:monospace; font-size:.8rem; color:#1d4ed8"><?php echo e($order->transaction_id ?? '-'); ?></td>
                        <td><span class="badge <?php echo e($tipeBadge); ?>"><?php echo e($tipeLabel); ?></span></td>
                        <td style="max-width:200px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap" title="<?php echo e($item); ?>"><?php echo e($item); ?></td>
                        <td>
                            <strong><?php echo e($order->customer_name); ?></strong>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->customer_email): ?><br><small style="color:#94a3b8"><?php echo e($order->customer_email); ?></small><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td style="white-space:nowrap; font-size:.8rem"><?php echo e($order->customer_phone); ?></td>
                        <td style="white-space:nowrap; font-size:.8rem"><?php echo e($order->trip_date?->format('d M Y') ?? '-'); ?></td>
                        <td style="white-space:nowrap; font-size:.8rem"><?php echo e($order->trip_end_date?->format('d M Y') ?? '-'); ?></td>
                        <td style="text-align:center"><?php echo e($order->quantity); ?></td>
                        <td style="text-align:right; font-weight:700; white-space:nowrap">Rp <?php echo e(number_format($order->total_price,0,',','.')); ?></td>
                        <td><span class="badge <?php echo e($statusBadge); ?>"><?php echo e($statusLabel); ?></span></td>
                        <td><span class="badge <?php echo e($payBadge); ?>"><?php echo e($payLabel); ?></span></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="13" class="no-data"><div class="ico">📭</div><div>Tidak ada pesanan untuk periode ini.</div></td></tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($orders->count() > 0): ?>
                <tfoot>
                    <tr>
                        <td colspan="10" style="text-align:right; color:#64748b">Total Pendapatan (non-cancelled):</td>
                        <td style="text-align:right; color:#16a34a">Rp <?php echo e(number_format($orders->where('status','!=','cancelled')->sum('total_price'),0,',','.')); ?></td>
                        <td colspan="2"></td>
                    </tr>
                </tfoot>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </table>
        </div>
    </div>

</div>
</main>
</body>
</html>
<?php /**PATH D:\PROYEK\WEBSITE WISATA\WISATA SEDERHANA\northsumateratrip.com\resources\views/pages/laporan-pesanan.blade.php ENDPATH**/ ?>