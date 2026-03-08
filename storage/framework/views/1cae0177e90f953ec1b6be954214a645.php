

<?php $__env->startSection('title', ($page->meta_title ?? $page->title) . ' - ' . ($settings['site_name'] ?? 'NorthSumateraTrip')); ?>
<?php $__env->startSection('meta_description', $page->meta_description ?? ''); ?>

<?php $__env->startSection('content'); ?>
<section class="pt-32 pb-16 bg-white min-h-screen">
    <div class="container mx-auto px-4 max-w-4xl">
        <h1 class="text-3xl md:text-5xl font-bold text-slate-900 dark:text-white tracking-tight mb-8"><?php echo e($page->title); ?></h1>
        <div class="prose prose-lg max-w-none text-slate-700">
            <?php echo $page->content; ?>

        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROYEK\WEBSITE WISATA\WISATA SEDERHANA\northsumateratrip.com\resources\views\pages\static-page.blade.php ENDPATH**/ ?>