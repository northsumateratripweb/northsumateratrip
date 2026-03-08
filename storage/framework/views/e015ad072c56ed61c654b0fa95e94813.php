<footer class="bg-slate-950 text-white pt-20 pb-10 overflow-hidden relative">
    <!-- Decorative -->
    <div class="absolute top-0 left-1/4 w-[400px] h-[400px] bg-blue-600/5 blur-[100px] rounded-full -translate-y-1/2 pointer-events-none"></div>
    
    <!-- Top gradient line -->
    <div class="absolute top-0 inset-x-0 h-px bg-gradient-to-r from-transparent via-blue-500/30 to-transparent"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 lg:gap-16 mb-14">

            <!-- Brand Column -->
            <div class="lg:col-span-5">
                <a href="<?php echo e(route('home')); ?>" class="group flex items-center gap-3 mb-7">
                    <div class="w-10 h-10 bg-blue-700 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-500/20 group-hover:rotate-12 transition-transform duration-300">
                        <i class="fas fa-route"></i>
                    </div>
                    <div>
                        <span class="text-xl font-black text-white tracking-tight uppercase">North<span class="text-blue-500">SumateraTrip</span></span>
                        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider leading-none mt-0.5"><?php echo e(__('ui.site_premium')); ?></p>
                    </div>
                </a>
                <p class="text-slate-400 text-sm leading-relaxed mb-8 max-w-sm">
                    <?php echo e($settings['site_description'] ?? 'Layanan private trip premium untuk pengalaman perjalanan terbaik Anda.'); ?>

                </p>
                <div class="flex items-center gap-2.5">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = ['facebook', 'instagram', 'tiktok', 'youtube']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $social): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($settings[$social.'_url'] ?? false): ?>
                            <a href="<?php echo e($settings[$social.'_url']); ?>" target="_blank" class="w-9 h-9 bg-slate-900 border border-slate-800 rounded-xl flex items-center justify-center text-slate-500 hover:bg-blue-700 hover:text-white hover:border-blue-700 transition-all duration-200">
                                <i class="fab fa-<?php echo e($social); ?> text-sm"></i>
                            </a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="lg:col-span-3">
                <div class="flex items-center gap-2 mb-5">
                    <div class="w-5 h-0.5 bg-blue-600"></div>
                    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest"><?php echo e(__('ui.quick_links')); ?></h4>
                </div>
                <ul class="space-y-3.5">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = [
                        ['route' => 'packages',       'label' => __('ui.nav_packages')],
                        ['route' => 'car-rental',     'label' => __('ui.nav_car_rental')],
                        ['route' => 'rental-package', 'label' => __('ui.nav_rental_package')],
                        ['route' => 'hotels',         'label' => __('ui.nav_hotels')],
                        ['route' => 'gallery',        'label' => __('ui.nav_gallery')],
                        ['route' => 'blog.index',     'label' => __('ui.nav_blog')],
                    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <a href="<?php echo e(route($link['route'])); ?>" class="text-slate-400 hover:text-blue-400 text-sm transition-colors flex items-center gap-2 group">
                                <span class="w-1 h-1 rounded-full bg-blue-600 opacity-0 group-hover:opacity-100 transition-opacity flex-shrink-0"></span>
                                <?php echo e($link['label']); ?>

                            </a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </ul>
            </div>

            <!-- Contact Column -->
            <div class="lg:col-span-4">
                <div class="flex items-center gap-2 mb-5">
                    <div class="w-5 h-0.5 bg-blue-600"></div>
                    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest"><?php echo e(__('ui.contact_us_footer')); ?></h4>
                </div>
                <div class="space-y-5">
                    <div class="flex items-start gap-3.5">
                        <div class="w-9 h-9 bg-slate-900 border border-slate-800 rounded-xl flex items-center justify-center text-blue-500 flex-shrink-0 text-sm">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-600 uppercase tracking-wider mb-0.5"><?php echo e(__('ui.office')); ?></p>
                            <p class="text-slate-400 text-sm leading-relaxed"><?php echo e($settings['site_address'] ?? 'Sumatera Utara, Indonesia'); ?></p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3.5">
                        <div class="w-9 h-9 bg-slate-900 border border-slate-800 rounded-xl flex items-center justify-center text-emerald-500 flex-shrink-0">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-600 uppercase tracking-wider mb-0.5">WhatsApp</p>
                            <p class="text-slate-400 text-sm"><?php echo e($settings['whatsapp_display'] ?? '+62 812-3456-7890'); ?></p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3.5">
                        <div class="w-9 h-9 bg-slate-900 border border-slate-800 rounded-xl flex items-center justify-center text-blue-400 flex-shrink-0 text-sm">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-600 uppercase tracking-wider mb-0.5">Email</p>
                            <p class="text-slate-400 text-sm"><?php echo e($settings['site_email'] ?? 'hello@northsumateratrip.com'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="pt-8 border-t border-slate-900 flex flex-col sm:flex-row justify-between items-center gap-4">
            <p class="text-slate-600 text-xs">
                &copy; <?php echo e(date('Y')); ?> <span class="text-slate-400 font-medium">NorthSumateraTrip</span>. <?php echo e(__('ui.all_rights')); ?>

            </p>
            <div class="flex items-center gap-6">
                <a href="<?php echo e(route('legal.privacy')); ?>" class="text-slate-600 hover:text-slate-300 text-xs transition-colors"><?php echo e(__('ui.privacy_policy')); ?></a>
                <a href="<?php echo e(route('legal.terms')); ?>" class="text-slate-600 hover:text-slate-300 text-xs transition-colors"><?php echo e(__('ui.terms_of_service')); ?></a>
            </div>
        </div>
    </div>
</footer>
<?php /**PATH D:\PROYEK\WEBSITE WISATA\WISATA SEDERHANA\northsumateratrip.com\resources\views\partials\footer.blade.php ENDPATH**/ ?>