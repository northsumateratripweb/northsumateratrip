

<?php $__env->startSection('title', $page->title . ' - ' . ($settings['site_name'] ?? 'NorthSumateraTrip')); ?>
<?php $__env->startSection('meta_description', $page->meta_description ?? substr(strip_tags($page->content), 0, 160)); ?>

<?php $__env->startSection('content'); ?>
<div class="pt-32 pb-4 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex text-sm text-slate-600">
            <a href="<?php echo e(route('home')); ?>" class="hover:text-blue-600">Home</a>
            <span class="mx-2">/</span>
            <span class="text-slate-900"><?php echo e($page->title); ?></span>
        </nav>
    </div>
</div>

<section class="py-12 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl md:text-5xl font-bold text-slate-900 dark:text-white tracking-tight mb-8"><?php echo e($page->title); ?></h1>
        
        <div class="prose prose-lg max-w-none text-slate-700">
            <?php echo $page->content; ?>

        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROYEK\WEBSITE WISATA\WISATA SEDERHANA\northsumateratrip.com\resources\views\pages\static.blade.php ENDPATH**/ ?>