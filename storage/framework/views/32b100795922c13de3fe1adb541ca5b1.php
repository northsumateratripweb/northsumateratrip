

<?php $__env->startSection('title', 'Sewa Mobil Sumatera - NorthSumateraTrip'); ?>
<?php $__env->startSection('meta_description', 'Sewa mobil murah di Sumatera dengan supir profesional. Pilihan armada lengkap mulai dari Avanza, Innova, hingga Hiace.'); ?>

<?php $__env->startSection('content'); ?>
    <div class="pt-36 md:pt-48 pb-32 max-w-7xl mx-auto px-6 lg:px-8">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-10 mb-16">
            <div class="max-w-3xl">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-8 h-0.5 bg-blue-600"></div>
                    <span class="text-xs font-bold text-blue-600 uppercase tracking-[0.2em]"><?php echo e(__('ui.hero_badge')); ?></span>
                </div>
                <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-[1.1] mb-5">
                    <?php echo e(__('ui.nav_car_rental')); ?> <span class="text-blue-600">Sumatera</span>
                </h1>
                <p class="text-slate-400 font-medium text-lg leading-relaxed max-w-2xl">
                    <?php echo e($category?->description ?? __('ui.car_fleet_sub')); ?>

                </p>
            </div>
            
            <div class="flex flex-wrap gap-4">
                <div class="px-6 py-3.5 bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-2xl">
                    <p class="text-xs text-slate-400 font-medium mb-0.5"><?php echo e(__('ui.starting_from')); ?></p>
                    <p class="text-lg font-extrabold text-blue-600 leading-none"><?php echo e(currency(450000)); ?><span class="text-xs text-slate-400 font-medium ml-1"><?php echo e(__('ui.per_day')); ?></span></p>
                </div>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="mb-14 p-6 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-lg shadow-slate-900/[0.03]">
            <form action="<?php echo e(route('car-rental')); ?>" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-5 items-end">
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 block"><?php echo e(__('ui.capacity')); ?></label>
                    <select name="capacity" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-xl px-4 py-3 text-sm font-medium outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                        <option value=""><?php echo e(__('ui.all_categories')); ?></option>
                        <option value="4" <?php echo e(request('capacity') == '4' ? 'selected' : ''); ?>>4 <?php echo e(__('ui.person')); ?></option>
                        <option value="6" <?php echo e(request('capacity') == '6' ? 'selected' : ''); ?>>6-7 <?php echo e(__('ui.person')); ?></option>
                        <option value="12+" <?php echo e(request('capacity') == '12+' ? 'selected' : ''); ?>>12+ <?php echo e(__('ui.person')); ?> (Hiace/Elf)</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 block"><?php echo e(__('ui.transmission')); ?></label>
                    <select name="transmission" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-xl px-4 py-3 text-sm font-medium outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                        <option value=""><?php echo e(__('ui.all_categories')); ?></option>
                        <option value="manual" <?php echo e(request('transmission') == 'manual' ? 'selected' : ''); ?>>Manual</option>
                        <option value="matic" <?php echo e(request('transmission') == 'matic' ? 'selected' : ''); ?>>Automatic</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 block">Brand</label>
                    <input type="text" name="brand" value="<?php echo e(request('brand')); ?>" placeholder="Contoh: Toyota, Honda..." class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-xl px-4 py-3 text-sm font-medium outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 py-3 bg-blue-600 text-white rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/20">
                        Filter
                    </button>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request()->anyFilled(['capacity', 'transmission', 'brand'])): ?>
                    <a href="<?php echo e(route('car-rental')); ?>" class="px-5 py-3 bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-slate-200 transition-all">
                        Reset
                    </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </form>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($carRentals->isEmpty()): ?>
            <div class="py-24 text-center bg-slate-50 dark:bg-slate-900/50 rounded-3xl border-2 border-dashed border-slate-200 dark:border-slate-800">
                <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-6 text-slate-300">
                    <i class="fas fa-car text-2xl"></i>
                </div>
                <p class="text-slate-400 font-bold uppercase tracking-wider text-sm"><?php echo e(__('ui.no_packages')); ?></p>
                <a href="<?php echo e(route('car-rental')); ?>" class="inline-block mt-5 text-blue-600 font-bold text-xs uppercase tracking-wider hover:underline">Lihat Semua Armada</a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $carRentals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $carRental): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('car.detail', $carRental->slug)); ?>" class="group flex flex-col h-full bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 transition-all duration-500 hover:shadow-xl hover:shadow-blue-900/[0.06] hover:-translate-y-1 overflow-hidden block cursor-pointer">
                        <!-- Image Container -->
                        <div class="relative h-52 overflow-hidden">
                            <img src="<?php echo e($carRental->image_url); ?>" alt="<?php echo e($carRental->name); ?>" class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            
                            <!-- Badges -->
                            <div class="absolute top-4 left-4 flex flex-col gap-2">
                                <span class="px-3.5 py-1.5 bg-white/90 dark:bg-slate-900/90 backdrop-blur-sm rounded-xl text-xs font-bold text-blue-600 dark:text-blue-400 border border-white/20 dark:border-slate-800 shadow-sm">
                                    <?php echo e($carRental->brand); ?>

                                </span>
                            </div>


                        </div>

                        <!-- Content -->
                        <div class="flex-1 flex flex-col p-5">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="flex items-center gap-1.5 px-2.5 py-1 bg-slate-50 dark:bg-slate-800 rounded-lg text-xs font-medium text-slate-400 border border-slate-100 dark:border-slate-700">
                                    <svg class="w-3 h-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    <?php echo e($carRental->capacity); ?> Kursi
                                </span>
                                <span class="flex items-center gap-1.5 px-2.5 py-1 bg-slate-50 dark:bg-slate-800 rounded-lg text-xs font-medium text-slate-400 border border-slate-100 dark:border-slate-700 capitalize">
                                    <svg class="w-3 h-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                                    <?php echo e($carRental->transmission ?? 'Manual'); ?>

                                </span>
                            </div>

                            <h3 class="font-bold text-slate-900 dark:text-white text-base leading-snug mb-3 line-clamp-1 group-hover:text-blue-600 transition-colors">
                                <?php echo e($carRental->name); ?>

                            </h3>
                            
                            <!-- Bottom Info -->
                            <div class="mt-auto flex items-center justify-between pt-4 border-t border-slate-50 dark:border-slate-800">
                                <div>
                                    <p class="text-xs text-slate-400 font-medium mb-0.5"><?php echo e(__('ui.starting_from')); ?></p>
                                    <p class="text-lg font-extrabold text-slate-900 dark:text-white tracking-tight"><?php echo e(currency($carRental->price_per_day)); ?><span class="text-xs text-slate-400 font-medium ml-1"><?php echo e(__('ui.per_day')); ?></span></p>
                                </div>
                                <span class="w-10 h-10 bg-slate-50 dark:bg-slate-800 rounded-xl flex items-center justify-center text-slate-400 group-hover:bg-blue-600 group-hover:text-white transition-all duration-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <div class="mt-16">
                <?php echo e($carRentals->links()); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\PROYEK\WEBSITE WISATA\WISATA SEDERHANA\northsumateratrip.com\resources\views/pages/car-rental.blade.php ENDPATH**/ ?>