
<?php $__env->startSection('title', 'Dashboard Laporan Pesanan'); ?>
<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <h1 class="mb-4">Dashboard Laporan Pesanan</h1>
    <form method="get" action="<?php echo e(route('dashboard.laporan')); ?>" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <label>Tahun</label>
                <input type="number" name="tahun" value="<?php echo e($tahun); ?>" class="form-control">
            </div>
            <div class="col-md-3">
                <label>Bulan</label>
                <input type="number" name="bulan" value="<?php echo e($bulan); ?>" class="form-control" min="1" max="12">
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
                    <h2><?php echo e($totalBulan); ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5>Total Pesanan Tahun Ini</h5>
                    <h2><?php echo e($totalTahun); ?></h2>
                </div>
            </div>
        </div>
    </div>
    <a href="<?php echo e(route('laporan.pesanan', ['tahun' => $tahun, 'bulan' => $bulan])); ?>" class="btn btn-success">Lihat Tabel Laporan</a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROYEK\WEBSITE WISATA\WISATA SEDERHANA\northsumateratrip.com\resources\views\pages\dashboard-laporan.blade.php ENDPATH**/ ?>