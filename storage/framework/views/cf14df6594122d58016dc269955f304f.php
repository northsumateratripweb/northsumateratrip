<?php
    $navItems = [
        ['route' => 'home',           'label' => __('ui.nav_home')],
        ['route' => 'packages',        'label' => __('ui.nav_packages')],
        ['route' => 'car-rental',      'label' => __('ui.nav_car_rental')],
        ['route' => 'rental-package',  'label' => __('ui.nav_rental_package')],
        ['route' => 'gallery',         'label' => __('ui.nav_gallery')],
        ['route' => 'blog.index',      'label' => __('ui.nav_blog')],
        ['route' => 'contact',         'label' => __('ui.nav_contact')],
    ];
?>

<header class="bg-white border-b border-gray-100 sticky top-0 z-50">
    <!-- Navbar Container -->
    <div class="max-w-7xl mx-auto px-4">
        <!-- Main Row: Content Centered & Balanced -->
        <div class="flex items-center justify-between h-14 md:h-16 gap-2">
            
            <!-- Left: Language & Currency Switcher -->
            <div class="flex-1 hidden md:flex items-center gap-3">
                <div class="flex items-center bg-gray-50 rounded-full p-1 border border-gray-100">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = ['id' => '🇮🇩', 'en' => '🇺🇸', 'ms' => '🇲🇾']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loc => $flag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('lang.switch', $loc)); ?>" 
                           class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider transition-all <?php echo e(app()->getLocale() == $loc ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-400 hover:text-gray-600'); ?>">
                            <?php echo e($flag); ?> <?php echo e(strtoupper($loc)); ?>

                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <div class="px-2 py-1 bg-blue-50 text-blue-600 rounded-lg text-[9px] font-black uppercase tracking-widest border border-blue-100">
                    <?php echo e(\App\Services\CurrencyService::code()); ?> (<?php echo e(\App\Services\CurrencyService::symbol()); ?>)
                </div>
            </div>

            <!-- Left: Mobile Lang Toggle (Small) -->
            <div class="md:hidden flex items-center">
                <div class="flex items-center bg-gray-50 rounded-lg p-0.5 border border-gray-100">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = ['id' => '🇮🇩', 'en' => '🇺🇸']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loc => $flag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(app()->getLocale() != $loc): ?>
                        <a href="<?php echo e(route('lang.switch', $loc)); ?>" class="p-1.5 text-[10px] grayscale hover:grayscale-0 transition-all">
                            <?php echo e($flag); ?>

                        </a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <!-- Center: Logo -->
            <a href="<?php echo e(route('home')); ?>" class="flex-shrink-0 px-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($settings['site_logo'])): ?>
                    <?php
                        $logoUrl = $settings['site_logo'];
                        if (!str_starts_with($logoUrl, 'http')) {
                            $logoUrl = asset('storage/' . $logoUrl);
                        }
                    ?>
                    <img src="<?php echo e($logoUrl); ?>" alt="<?php echo e($settings['site_name'] ?? 'NorthSumateraTrip'); ?>" class="h-9 md:h-12 w-auto object-contain">
                <?php else: ?>
                    <span class="text-xl font-black tracking-tighter text-gray-900 uppercase">
                        <?php echo e($settings['site_name'] ?? 'NST'); ?>

                    </span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </a>

            <!-- Right: Actions -->
            <div class="flex-1 flex justify-end items-center gap-4">
                <a href="https://wa.me/<?php echo e($settings['whatsapp_number'] ?? ''); ?>" class="hidden md:flex items-center gap-1.5 px-4 py-2 bg-green-50 text-green-600 rounded-full border border-green-100 text-[10px] font-bold uppercase tracking-widest hover:bg-green-100 transition-colors">
                    <i class="fab fa-whatsapp"></i> Chat CS
                </a>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="p-2 text-gray-600 hover:text-blue-600 transition-colors">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Quick Navigation Scroller (Strategic & Space-efficient) -->
    <div class="border-t border-gray-50 bg-white/50 backdrop-blur-sm overflow-x-auto no-scrollbar">
        <div class="max-w-7xl mx-auto">
            <ul class="flex items-center whitespace-nowrap px-4 py-2 md:py-3 gap-6 md:gap-10 justify-start md:justify-center">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $navItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item['route'] !== 'contact'): ?>
                    <li>
                        <a href="<?php echo e(route($item['route'])); ?>" class="text-[9px] md:text-[10px] font-bold uppercase tracking-[0.15em] text-gray-500 hover:text-blue-600 transition-all <?php echo e(request()->routeIs($item['route']) ? 'text-blue-600' : ''); ?>">
                            <?php echo e($item['label']); ?>

                        </a>
                    </li>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </ul>
        </div>
    </div>

    <!-- Mobile Full Menu Drawer -->
    <div id="mobile-navigation" class="hidden md:hidden bg-white border-t border-gray-100 shadow-xl absolute w-full z-[60]">
        <ul class="py-2">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $navItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                    <a href="<?php echo e(route($item['route'])); ?>" class="block px-8 py-4 text-xs font-bold uppercase tracking-widest text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                        <?php echo e($item['label']); ?>

                    </a>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <li class="px-8 py-4 border-t border-gray-50">
                <a href="https://wa.me/<?php echo e($settings['whatsapp_number'] ?? ''); ?>" class="flex items-center gap-3 text-green-600 font-bold text-xs uppercase tracking-widest">
                    <i class="fab fa-whatsapp text-lg"></i> Hubungi via WhatsApp
                </a>
            </li>
        </ul>
    </div>
</header>

<script>
    document.getElementById('mobile-menu-btn').addEventListener('click', function() {
        const menu = document.getElementById('mobile-navigation');
        menu.classList.toggle('hidden');
    });
</script>
<?php /**PATH D:\PROYEK\WEBSITE WISATA\WISATA SEDERHANA\northsumateratrip.com\resources\views/partials/navbar.blade.php ENDPATH**/ ?>