

<?php $__env->startSection('title', 'Gallery - ' . ($settings['site_name'] ?? 'NorthSumateraTrip')); ?>

<?php $__env->startSection('content'); ?>
<div class="pt-36 md:pt-48 pb-32 max-w-7xl mx-auto px-6 lg:px-8">
    <!-- Header Section -->
    <div class="max-w-3xl mb-16">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-8 h-0.5 bg-blue-600"></div>
            <span class="text-xs font-bold text-blue-600 uppercase tracking-[0.2em]">Photo Gallery</span>
        </div>
        <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-[1.1] mb-5">
            Gallery
        </h1>
        <p class="text-slate-400 font-medium text-lg leading-relaxed max-w-2xl">
            Kumpulan foto dari paket dan aktivitas trip kami
        </p>
    </div>

    <?php
        $items = $galleries ?? collect();
    ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($items->count() > 0): ?>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 md:gap-5">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="group relative overflow-hidden rounded-2xl bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 cursor-zoom-in transition-all duration-500 hover:shadow-xl hover:shadow-blue-900/[0.06] hover:-translate-y-0.5" onclick="openLightbox('<?php echo e($gallery->resolved_image_url); ?>', '<?php echo e($gallery->title); ?>')">
            <div class="aspect-[4/3] overflow-hidden">
                <img src="<?php echo e($gallery->resolved_image_url); ?>" 
                     alt="<?php echo e($gallery->title); ?>" 
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out">
            </div>
            <!-- Hover Overlay -->
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/70 via-slate-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-end p-4">
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
                    <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                    </div>
                </div>
                <h3 class="text-sm font-bold text-white line-clamp-1"><?php echo e($gallery->title); ?></h3>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($gallery->caption): ?>
                <p class="text-xs text-white/70 mt-0.5"><?php echo e($gallery->caption); ?></p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    <div class="mt-10">
        <?php echo e($items->appends(request()->query())->links()); ?>

    </div>
    <?php else: ?>
    <div class="relative overflow-hidden rounded-[2rem] border-2 border-dashed border-slate-200 dark:border-slate-800 p-12 md:p-24 text-center bg-white dark:bg-slate-900 shadow-sm">
        
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-blue-50/50 dark:bg-blue-900/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-slate-50/50 dark:bg-slate-800/10 rounded-full blur-3xl"></div>
        
        <div class="relative z-10">
            <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-xl shadow-blue-500/20 rotate-3">
                <i class="fas fa-camera-retro text-3xl text-white"></i>
            </div>
            <h3 class="text-2xl font-black text-slate-900 dark:text-white uppercase tracking-tight mb-3">Belum ada koleksi foto</h3>
            <p class="text-slate-400 font-medium max-w-sm mx-auto mb-8">Kami sedang menyiapkan dokumentasi perjalanan terbaik untuk Anda. Silakan kembali lagi beberapa saat lagi.</p>
            <a href="<?php echo e(route('home')); ?>" class="inline-flex items-center gap-2 px-8 py-3 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-full text-xs font-black uppercase tracking-widest transition-all hover:scale-105 hover:bg-slate-800">
                &larr; Kembali ke Beranda
            </a>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROYEK\WEBSITE WISATA\WISATA SEDERHANA\northsumateratrip.com\resources\views\pages\gallery.blade.php ENDPATH**/ ?>